#include<stdio.h>
#include<stdlib.h>

int main(int argc,char *argv[]){
    if(argc<2){
        printf("usage: %s <rows>",argv[0]);
        return -1;
    }
    int rows = atoi(argv[1]);
    for(int i=0;i<rows;i++){
        for(int j=0;j<i;j++){
            printf("* ");
        }
        printf("\n");
    }
}