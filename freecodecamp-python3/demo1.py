from pickle import NONE


print("START OF SIMPLE TYPES\n")
int1 = 5
float2 = 5.0
nothing = None
true1 = True
false2 = False


allsimpletypes = [type(int1), type(float2), type(nothing), type(true1), type(false2), type([])]
print(allsimpletypes)


print("END OF SIMPLE TYPES\n")

#---------------------------------------------------------------------------------------------------------------------------------------------------

print("START OF NUMBERS\n")
#Numbers
myint = 5
myfloat = 5.0
myint2 = int(myfloat)
#divide always result in float
myfloat2 = myint/1
myfloat3 = myint * 1
myfloat4 = myint * myfloat2
print("Always A/B float = " + str(myfloat2))
print("Not INT*INT float = " + str(myfloat3))
print("Always always INT*FLOAT float = " + str(myfloat4))
print("END OF INT\n")

dir(myint)
#---------------------------------------------------------------------------------------------------------------------------------------------------

print("START OF STRINGS AND LISTS\n")

#Strings
a = "abcd"
#Iterate on strings
for letter in a:
    print(letter + ' -  ')
    
#String to list 1
b = "aline;with;;separator;;;of;somesort"
blist = b.split(';')
for item in blist:
    print(item + " - ")
   
#String to list 2
b = "aline with  separator   of somesort"
blist = b.split()
for item in blist:
    print(item + " - ")
   
#String find match
email1 = "HELLO FROM the aaa@bbb.edu.cn domain email"
domain_start = email1.find('@')
domain_end = email1.find(' ', domain_start)

print(email1[domain_start+1:domain_end])
print(email1.find('@') > 0)

#String methods
print(dir(email1))

myl = [1,2,3,4,5]
myl.reverse()
print(myl)
myl.reverse()
print(myl)
#python3 trick
print(myl[::-1])

print("END OF STRINGS AND LISTS\n")

#---------------------------------------------------------------------------------------------------------------------------------------------------
