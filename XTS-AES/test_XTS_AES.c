/*  ======================================================================== *

                                    주 의 사 항


    1. 계산 중간 흐름은 다음 문서를 보고 비교하는 것을 추천함

		http://grouper.ieee.org/groups/1619/email/pdf00037.pdf

 *  ======================================================================== */

#include <stdio.h>
#include <stdint.h>
#include <string.h>
#include "XTS_AES.h"

typedef unsigned char BYTE;

uint8_t iv[]  = { 
    0x33, 0x33, 0x33, 0x33, 0x33, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
    0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00
};

uint8_t key[] = { 
	0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11, 0x11,
    0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22, 0x22
};

uint8_t plain[] = { 
	0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44,
    0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44, 0x44
};

uint8_t cipher[] = { 
	0xc4, 0x54, 0x18, 0x5e, 0x6a, 0x16, 0x93, 0x6e, 0x39, 0x33, 0x40, 0x38, 0xac, 0xef, 0x83, 0x8b,
    0xfb, 0x18, 0x6f, 0xff, 0x74, 0x80, 0xad, 0xc4, 0x28, 0x93, 0x82, 0xec, 0xd6, 0xd3, 0x94, 0xf0
};

int main(){
	BYTE tmp[64];

	// 암호화 테스트
	XTS_AES128(plain, tmp, 32, ENC, iv, key); // 파라미터 iv, key 추가
	printf("XTS_AES Encryption: %s\n", 0 == strncmp((char*) cipher, (char*) tmp, 32) ? "SUCCESS!" : "FAILURE!");
    
	// 복호화 테스트
	XTS_AES128(tmp, cipher, 32, DEC, iv, key); // 파라미터 iv, key 추가
	printf("XTS_AES Decryption: %s\n", 0 == strncmp((char*) tmp, (char*) plain, 32) ? "SUCCESS!" : "FAILURE!");

	return 0;
}