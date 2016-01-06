//
//  CTR_DRBG.c
//  
//
//  Created by Apple on 2015. 10. 29..
//
//

#include <stdio.h>
#include <string.h>
#include <stdint.h>
#include <time.h>
#include "AES128.h"

uint8_t init_v[]  = {
    0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f
};

uint8_t init_key[] = {
    0x2b, 0x7e, 0x15, 0x16, 0x28, 0xae, 0xd2, 0xa6, 0xab, 0xf7, 0x15, 0x88, 0x09, 0xcf, 0x4f, 0x3c
};

void init_ctr_drbg(BYTE *key, BYTE *v){
    int i;
    BYTE entropy_source[16];
    char buff[16];
    time_t now = time(NULL);
    strftime(buff, 16, "%H%M%S%H%M%S%S%S", localtime(&now));
    memcpy(entropy_source, buff, 16);
    
    for(i = 0; i < 16; i++){
        init_v[i] += 1;
    }
    AES128(init_v, key, init_key, ENC);
    
    for(i = 0; i < 16; i++){
        init_v[i] += 1;
    }
    AES128(init_v, v, init_key, ENC);
    
    for (i = 0; i < 16; i++) {
        key[i] = key[i] ^ entropy_source[i];
        v[i] = v[i] ^ entropy_source[i];
    }
}

BYTE *ctr_drbg(BYTE *r){
    int initial;
    int i, j;
    BYTE v[16];
    BYTE key[16];
    init_ctr_drbg(key, v);
    while (1){
        printf("Initialize? (Yes: 1, No: 0) - print 20 random numbers(test cases) "); // 테스트 : 랜덤넘버가 잘 출력되는지 확인
        scanf("%d", &initial);
        if (initial == 1) {
            for (j = 0; j < 20; j++){
                init_ctr_drbg(key, v);
                for (i = 0; i < 16; i++) {
                    v[i] += 1;
                }
                AES128(v, r, key, ENC);
                printf("[%d]", j+1);
                for (i = 0; i < 16; i++){
                    printf("0x%x ", r[i]);
                }
                printf("\n");
            }
        }
        else if (initial == 0) {
            for (j = 0; j < 20; j++){
                for (i = 0; i < 16; i++) {
                    v[i] += 1;
                }
                AES128(v, r, key, ENC);
                printf("[%d]", j+1);
                for (i = 0; i < 16; i++){
                    printf("0x%x ", r[i]);
                }
                printf("\n");
            }
        }
        else
            break;
    }
    
    return r;
}

int main(){
    BYTE *ran;
    BYTE random_number[16];
    int i;
    ran = ctr_drbg(random_number);
    printf("This is your random number : ");
    for (i = 0; i < 16; i++){
        printf("0x%x ", ran[i]);
    }
    printf("\n");

    return 0;
}