#Tules   are immutable, tuples are more memory & performance efficient compared to lists
#Strings are immutable
#Lists   are mutable

list1  = ['a', 'b', 'c']
tuple1 = ('a', 'b', 'c')

list1.append('d')
for letter in list1:
    print(letter, end = ' ')

for letter in tuple1:
    print(letter, end = ' ')

print()

print(list1[1], ' = ', tuple1[1])

print(type(list1), ' != ', type(tuple1))

#count & index are only availabe
print(dir(tuple1))
print("dir(list) != dir(tuple)")

(a, b) = ('hello', 'world')
print(a, b)
(a, b) = ['hello', 'world']
print(a, b)

# error --> 
#(a, b, c) = ['hello', 'world']
#(a, b) = ['hello', 'world', ' ']
# error <--

#parentheses are optional
a, b = 'hello', 'world'
print(a, b)

#will compare sequentially until TRUE|FALSE starting with tuple items in order
print((1, 2, 3)   < (99, 98, 97)) #1 < 99   = TRUE
print((100, 2, 3) < (99, 98, 97)) #100 < 99 = FALSE

#sort by keys, since dictionary has always unique-key, tuple sorting will never compare second args
sdict = {'g': 2, 'a': 1, 'e': 50, 'c': 3, }
print(sorted(sdict.items()))

#same result
for k, v in sorted(sdict.items()):
    print(k, v)

#sort by value
tmp = []
for k,v in sdict.items():
    tmp.append((v, k))

print(sorted(tmp))
print(sorted(tmp, reverse=True))