# Simple word counter
# could test against data generated by
# @see https://www.lipsum.com/ 

import os
os.chdir(os.path.dirname(os.path.abspath(__file__)))

file = open("./words.txt")

counter = {}
for line in file:
    words = line.split()
    for word in words:
        cleanword = word.rstrip('.,;')
        counter[cleanword] = counter.get(cleanword, 0) + 1

print("Word counter, total " + str(sum(counter.values())) + " words")

top = []
for key,value in counter.items():
    top.append((value, key))
    print(key,  ":", value)

print("TOP10 Words in order, most frequent first")

for k,v in sorted(top, reverse=True)[:10]:
    print(v, k);

#List comprehension (one-liner)
print(sorted((v, k) for k,v  in counter.items()))
    

    