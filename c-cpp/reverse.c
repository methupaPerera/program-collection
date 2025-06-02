#include <stdio.h>
#include <string.h>

void copy(char *s1, char *s2);
void reverse(char *t);

int main() {
    char t[1000];
    void copy();
    void reverse();

    printf("Type a string to reverse: ");
    fgets(t, sizeof(t), stdin);

    // copy("Hello world", t);
    reverse(t);
    printf("%s\n", t);
}

// Function for copying character arrays.
void copy(char *s1, char *s2) {
    int i;
    for (i = 0; (s2[i] = s1[i]); i++);
}

void reverse(char *t) {
    int len_of_t, count;
    void copy();
    char rev_t[1000];

    // Getting the length of the string. [strlen()]
    for (len_of_t = 0; t[len_of_t]; len_of_t++); 

    copy(t, rev_t); // Copying string. [strcpy()]

    count = len_of_t;
    
    for (int i = 0; i < len_of_t; i++) {
        count -= 1;
        if (count < 0) break;;
        t[i] = rev_t[count];
    }
}