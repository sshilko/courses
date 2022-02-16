mylist = list()
print(type(mylist))

words = 'His e-mail is q-lar@freecodecamp.org'
pieces = words.split()
parts = pieces[3].split('-')
n = parts[1]
print(n)

mydictionary = dict()
mydictionary["a"] = "aval1"
mydictionary["b"] = "bval22"
mydictionary["c"] = "cval333"
#mydictionary[['z']] = "zval444"
print(mydictionary)
print(mydictionary["c"])
#print(mydictionary["d"])
print(type(mydictionary))

mydictionary0 = {}
mydictionary1 = {'a': 'aval'}
print(mydictionary1)
print(mydictionary1.get('a'))
print(mydictionary1.get('b', 'somedefaultforb'))
print(type(mydictionary1))
