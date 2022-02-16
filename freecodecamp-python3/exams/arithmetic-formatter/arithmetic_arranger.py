def arithmetic_arranger(problems: list, addSolution: bool = False) -> str:

  if len(problems) > 5:
    return "Error: Too many problems."
    
  tab = " " * 4
  pad = 2
  
  a = list()
  b = list()
  operand = list()
  solution = list()
  
  for task in problems:
    tmp = task.split()

    if tmp[0].isnumeric() and tmp[2].isnumeric():
      pass
    else:
      return "Error: Numbers must only contain digits."

    if tmp[1] == '+':
      solution.append(int(tmp[0]) + int(tmp[2]))
    elif tmp[1] == '-':
      solution.append(int(tmp[0]) - int(tmp[2]))
    else:
      return "Error: Operator must be '+' or '-'."

    if len(tmp[0]) <= 4 and len(tmp[2]) <= 4:
      pass
    else:
      return "Error: Numbers cannot be more than four digits."
      
    a.append(tmp[0])
    operand.append(tmp[1])
    b.append(tmp[2])
    

  line_1 = str()
  line_2 = str()
  line_3 = str()
  line_4 = str()
  
  for i in range(len(a)):
    blk_len = max(len(a[i]), len(b[i])) + pad
    line_1 += str(a[i]).rjust(blk_len, " ")
    line_2 += operand[i] + ' '
    line_2 += str(b[i]).rjust(blk_len - 2, " ")
    line_3 += ("-" * blk_len)
    line_4 += str(solution[i]).rjust(blk_len, " ")

    if i < len(a) - 1:
      line_1 += tab
      line_2 += tab
      line_3 += tab
      line_4 += tab

  result = line_1 + "\n" + line_2 + "\n" + line_3  
  if addSolution == True:
    result += "\n" + line_4
    
  return result