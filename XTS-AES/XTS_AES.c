/*  ======================================================================== *

                                    주 의 사 항


    1. AES.c를 먼저 구현한 다음, 해당 파일을 구현함
    2. 사전에 주어진 메뉴얼 속 수도코드를 참고하여 구현함
    3. 구현은 다양한 방식으로 이뤄질 수 있음
    4. AES.h에 정의된 AES128(...) 함수만을 이용해서 구현해야 함
    5. XTS_AES128(...) 함수의 호출과 리턴이 여러번 반복되더라도 메모리 누수가 생기지 않게 함

 *  ======================================================================== */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "XTS_AES.h"
#include "AES128.h"

static void xts_mult_x(uint8_t *I);



/*  <128비트 XTS_AES 암복호화 함수>
 *  
 *  mode가 ENC일 경우 평문을 암호화하고, DEC일 경우 암호문을 복호화하는 함수
 *
 *  [ENC 모드]
 *  plain   평문 바이트 배열
 *  cipher  결과(암호문)이 담길 바이트 배열. 호출하는 사용자가 사전에 메모리를 할당하여 파라미터로 넘김
 *  size    평문 크기 (바이트 단위)
 *  key     256비트 암호키 (32바이트). 상위 16바이트는 key1, 하위 16바이트는 key2
 *
 *  [DEC 모드]
 *  plain   결과(평문)가 담길 바이트 배열. 호출하는 사용자가 사전에 메모리를 할당하여 파라미터로 넘김
 *  cipher  암호문 바이트 배열
 *  size    암호문 크기 (바이트 단위)
 *  key     256비트 암호키 (32바이트). 상위 16바이트는 key1, 하위 16바이트는 key2
 */
void XTS_AES128(BYTE *plain, BYTE *cipher, unsigned int size, int mode, BYTE *iv, BYTE *key){ // 파라미터 iv, key 추가
    int i, j;
    BYTE *key1;
    BYTE *key2;
    BYTE T[16];
    BYTE T2[16];
    BYTE PP[16];
    BYTE CC[16];
    int rest_case_size = size % 16;
    key1 = (BYTE *)malloc(sizeof(BYTE) * 16);
    key2 = (BYTE *)malloc(sizeof(BYTE) * 16);
    memcpy(key1, key, sizeof(BYTE) * 16);
    memcpy(key2, key + sizeof(BYTE) * 16, sizeof(BYTE) * 16);
    
    AES128(iv, T, key2, ENC);
    
    switch(mode){
        case ENC:
            for (i = 0; i < size/16; i++) {
                for(j = 0; j < 16; j++){
                    PP[j] = T[j] ^ plain[j + (i * 16)];
                }
                AES128(PP, CC, key1, ENC);
                for(j = 0; j < 16; j++){
                    cipher[j + (i * 16)] = T[j] ^ CC[j];
                }
                xts_mult_x(T);
            }
            if(rest_case_size != 0){
                for(j = 0; j < rest_case_size; j++){
                    cipher[j + (i * 16)] = cipher[j + (i - 1) * 16];
                    PP[j] = T[j] ^ plain[j + i * 16];
                }
                for(; j < 16; j++){
                    PP[j] = T[j] ^ cipher[j + (i - 1) * 16];
                }
                AES128(PP, CC, key1, ENC);
                for(j = 0; j < 16; j++){
                    cipher[j + (i - 1) * 16] = T[j] ^ CC[j];
                }
            }
            break;
            
        case DEC:
            for (i = 0; i < size/16 - 1; i++) {
                for(j = 0; j < 16; j++){
                    CC[j] = T[j] ^ cipher[j + (i * 16)];
                }
                AES128(PP, CC, key1, DEC);
                for(j = 0; j < 16; j++){
                    plain[j + (i * 16)] = T[j] ^ PP[j];
                }
                xts_mult_x(T);
            }
            if(rest_case_size == 0){
                for(; i < size/16; i++){
                    for(j = 0; j < 16; j++){
                        CC[j] = T[j] ^ cipher[j + (i * 16)];
                    }
                    AES128(PP, CC, key1, DEC);
                    for(j = 0; j < 16; j++){
                        plain[j + (i * 16)] = T[j] ^ PP[j];
                    }
                    xts_mult_x(T);
                }
            }
            else{
                memcpy(T2,T,sizeof(BYTE) * 16);
                xts_mult_x(T);
                for(j = 0; j < 16; j++){
                    CC[j] = T[j] ^ cipher[j + (i * 16)];
                }
                AES128(PP, CC, key1, DEC);
                for(j = 0; j < rest_case_size; j++){
                    plain[j + (i+1) * 16] = T[j] ^ PP[j];
                    CC[j] = T2[j] ^ cipher[j + (i+1) * 16];
                }
                for(; j < 16; j++){
                    CC[j] = T2[j] ^ T[j] ^ PP[j];
                }
                AES128(PP, CC, key1, DEC);
                for(j = 0; j < 16; j++){
                    plain[j + (i * 16)] = T2[j] ^ PP[j];
                }
            }
            break;
            
        default:
            fprintf(stderr, "Invalid mode!\n");
            exit(1);
    }

}

static void xts_mult_x(uint8_t *I)
{
    uint32_t x;
    uint8_t t, tt;
    
    for (x = t = 0; x < 16; x++) {
        tt   = I[x] >> 7;
        I[x] = ((I[x] << 1) | t) & 0xFF;
        t    = tt;
    }
    if (tt) {
        I[0] ^= 0x87;
    } 
}
