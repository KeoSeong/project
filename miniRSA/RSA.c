//
//  RSA.c
//

#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <math.h>
#include <string.h>

#define MAX_STR_SIZE 100

typedef unsigned long ulong;

void mRSAkeygen(ulong *p, ulong *q, ulong *e, ulong *d, ulong *n);
int mRSAcipher(char *ibuf, int len, char *obuf, ulong k, ulong n);
ulong randomNumGenerator1();
ulong randomNumGenerator2(ulong randomNum1);
int MillerRabinAlgorithm(ulong n);
ulong gcd(ulong a, ulong b);
ulong extendEuclid(ulong r1, ulong r2);
void bitBox(char *ibuf, int *bits, int size);
ulong calcPowMod(ulong a, ulong q, ulong n);
void bitBox2(int deci, int *bits, int size);

int main(){

    ulong p, q, e, d, n;
    char str_read[MAX_STR_SIZE];
    char tmp[strlen(str_read)];
    char obuf[strlen(str_read)];
    printf("write a message : ");
    fgets(str_read, MAX_STR_SIZE, stdin);
    do {
        mRSAkeygen(&p, &q, &e, &d, &n);
        printf("\n\n----------Message -> Cipher----------\n\n");
        mRSAcipher(str_read, strlen(str_read), obuf, e, n);
        printf("\n\n----------Cipher -> Message----------\n\n");
        char result[strlen(obuf)];
        mRSAcipher(obuf, strlen(str_read), result, d, n);
        printf("\nresult = %s\n", result);
        strcpy(tmp, result);
    } while (strcmp(str_read, tmp));

    return 0;
}

void mRSAkeygen(ulong *p, ulong *q, ulong *e, ulong *d, ulong *n){
    ulong pi;
    *p = randomNumGenerator1();
    *q = randomNumGenerator2(*p);
    *n = *p * *q;
    printf("n:%lu\n", *n);
    pi = (*p - 1) * (*q - 1);
    printf("pi:%lu\n", pi);
    do {
        *e = rand() % pi;
    } while (gcd(*e, pi) != 1 || *e <= 1);
    printf("e:%lu\n", *e);
    *d = extendEuclid(pi, *e);
    printf("d:%lu\n\n", *d);
}

int mRSAcipher(char *ibuf, int len, char *obuf, ulong k, ulong n){
    int i, j, l, bitSize = len * 8, block = (int)(log(n) / log(2)) + 1, temp = bitSize % block, padding = block - temp, *binaryC, buf1[block], buf2[bitSize + padding];
    int M[bitSize+padding];
    ulong changeM[(bitSize + padding) / block], C[(bitSize + padding) / block];
    int bitsPadding = (bitSize + padding) % 8, flag;
    if (bitsPadding == 0) flag = 0;
    else flag = 1;
    int buf3[bitSize + padding + flag];
    printf("bitSize: %d, block: %d, temp: %d, padding: %d, bitSize + padding: %d\n\n", bitSize, block, temp, padding, bitSize + padding);
    
    bitBox(ibuf, M, bitSize + padding);
    printf("M: ");
    for (i = 0; i < bitSize + padding; i++) {
        printf("%d", M[i]);
        if ((i + 1) % block == 0)
            printf("\n");
    }
    printf("\n");
    
    for (j=0; j <(bitSize+padding)/block; j++) {
        changeM[j] = 0;
    }
    for (j = 0; j < (bitSize + padding) / block; j++) {
        for (l = 0; l < block; l++) {
            if (M[j * block + l] == 1) {
                changeM[j] += (ulong)pow(2, block - l - 1);
            }
        }
    }
    for (i = 0; i < (bitSize + padding) / block; i++) {
        printf("M[%d]:%lu\n", i + 1, changeM[i]);
    }
    
    for (i = 0; i < (bitSize + padding) / block; i++) {
        C[i] = calcPowMod(changeM[i], k, n);
    }
    
    for (i = 0; i < (bitSize + padding) / block; i++) {
        printf("C[%d]:%lu\n", i + 1, C[i]);
    }

    for (i = 0; i < (bitSize + padding) / block; i++) {
        bitBox2(C[i], buf1, block);
        for (j = 0; j < block; j++) {
            buf2[i * block + j] = buf1[j];
        }
    }
    
    printf("\nC: ");
    for (i = 0; i < bitSize + padding; i++) {
        printf("%d", buf2[i]);
        if ((i + 1) % block == 0)
            printf("\n");
    }
    printf("\n");
    
    for (j=0; j<(bitSize+padding)/8+flag; j++) {
        buf3[j] = 0;
        
    }
    
    for (j = 0; j < (bitSize + padding) / 8 + flag; j++) {
        for (l = 0; l < 8; l++) {
            if (buf2[j * 8 + l] == 1) {
                buf3[j] += (ulong)pow(2, 8 - l - 1);
            }
        }
    }
    
    printf("C(character): ");
    for (i = 0; i < (bitSize + padding) / 8 + flag; i++) {
        printf("%d[%x] ", buf3[i], buf3[i]);
    }
    printf("\n");
    
    for (i = 0; i < (bitSize + padding) / 8 + flag; i++) {
        obuf[i] = buf3[i];
    }
    obuf[i] = '\0';
    
    return 0;
    
}

ulong randomNumGenerator1(){
    ulong randomNum1;
    srand(time(NULL));
    do {
        randomNum1 = rand() % (ulong)pow(2, 16);
    } while ((randomNum1 % 2) == 0 || MillerRabinAlgorithm(randomNum1) == 0);
    printf("p:%lu\n", randomNum1);
    return randomNum1;
}

ulong randomNumGenerator2(ulong randomNum1){
    ulong randomNum2, n;
    srand(time(NULL));
    do {
        randomNum2 = rand() % (ulong)pow(2,32)/(ulong)randomNum1;
    } while ((randomNum2 % 2) == 0 || (randomNum1 * randomNum2 < (ulong)pow(2, 24)) || (randomNum1 * randomNum2 >= (ulong)pow(2, 32)) || MillerRabinAlgorithm(randomNum2) == 0);
    printf("q:%lu\n", randomNum2);
    return randomNum2;
}

int MillerRabinAlgorithm(ulong n){ // return 0 : composite(소수가 아니다.), return 1 : inconclusive(소수 일 수도 있다.)
    ulong i, a, b, k = 0, q, j, temp = n - 1;
    do {
        temp /= 2;
        k++;
    } while ((temp % 2) == 0);
    q = temp;
    for (i = 0; i < 100; i++) {
        do {
            a = rand() % (ulong)(n - 1);
        } while (a <= 1);
        if (gcd(a, n) != 1) return 0;
        b = (ulong)pow(a, q) % n;
        if (b == 1 || b == n - 1) continue;
        int flag = 1;
        for (j = 0; j < k - 1; j++) {
            b = (b * b) % n;
            if (b == n - 1) {
                flag = 1;
                break;
            }
        }
        if (flag == 1) continue;
        else return 0;
    }
    return 1;
}

ulong gcd(ulong a, ulong b) {
    
    while (b != 0) {
        ulong temp = a % b;
        a = b;
        b = temp;
    }
    
    return (ulong)a;
}

ulong extendEuclid(ulong r1, ulong r2) {
    ulong r, q = 0, s, s1 = 1, s2 = 0, t, t1 = 0, t2 = 1, tmp = r1;
    while (r2 != 0) {
        q = r1 / r2;
        r = r1 % r2;
        s = s1 - q * s2;
        t = t1 - q * t2;
        r1 = r2;
        r2 = r;
        s1 = s2;
        s2 = s;
        t1 = t2;
        t2 = t;
    }
    if (r1 == 1) {
        return t1;
    }
    return 0;
}

void bitBox(char *ibuf, int *bits, int size){
    int i, temp = 128, ascii;
    for (i = 0; i < size; i++) {
        if (i == (i / 8) * 8) {
            if ((int)ibuf[i / 8] + 256 < 256)
                ascii = (int)ibuf[i / 8] + 256;
            else
                ascii = (int)ibuf[i / 8];
        }
        if (ascii >= temp) {
            ascii -= temp;
            bits[i] = 1;
        }
        else
            bits[i] = 0;
        temp /= 2;
        if (i == (i / 8) * 8 + 7) {
            temp = 128;
        }
        if (i >= strlen(ibuf) * 8) {
            bits[i] = 0;
        }
    }
}

ulong calcPowMod(ulong a, ulong q, ulong n){
    ulong result = 1;
    while(q > 0) {
        while(q % 2 == 0) {
            q /= 2;
            a = (a * a) % n;
        }
        q--;
        result = (result * a) % n;
    }
    return result;
}

void bitBox2(int deci, int *bits, int size){
    int i, de = deci, temp = (ulong)pow(2, size - 1);
    for (i = 0; i < size; i++) {
        if (de >= temp) {
            de -= temp;
            bits[i] = 1;
        }
        else
            bits[i] = 0;
        temp /= 2;
    }
}