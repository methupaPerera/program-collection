#include <stdio.h>
#include <string.h>

// This program will count the letters of each word in a paragraph.

void getFullParagraph(char *charArray);

int main() {
    void getFullParagraph();
    char textToAnalyze[1000];
    int currentIndex, charCount;

    printf("Enter a paragraph:\n");
    getFullParagraph(textToAnalyze);

    charCount = 0;

    for (currentIndex = 0; currentIndex < 1000; currentIndex++) {
        if (textToAnalyze[currentIndex] == ' ') {
            printf("=%d\n", charCount);
            charCount = 0;
            continue;
        }
        
        if (textToAnalyze[currentIndex] == '\0') {
            printf("=%d\n", charCount);
            break;
        }

        printf("%c", textToAnalyze[currentIndex]);
        charCount++;
    }

    return 0;
}

void getFullParagraph(char *charArray) {
    int character, index;

    while ((character = getchar()) != '\n') {
        charArray[index] = character;
        index++;
    }

    charArray[index] = '\0';
}