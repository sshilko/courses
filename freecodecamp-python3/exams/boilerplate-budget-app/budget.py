from __future__ import annotations
from typing import List, Dict

class Category:

  def __init__(self, name: str):
    #instance variables
    self.name: str = name.lower().capitalize()
    self.ledger: List[dict] = []

  def __str__(self) -> str:
    return self.report()

  def report(self) -> str:
    response: str = ''
    response += self.name.center(30, '*')
    if len(self.ledger) > 0:
      response += "\n"

    total: float = 0
    for item in self.ledger:
      response += str(item["description"])[: 23].ljust(23, " ")
      response += str(format(float(item["amount"]), '.2f')).rjust(7, " ")
      response += "\n"
      total    += float(item["amount"])

    if total > 0:
      response += "Total: {0:.2f}".format(total)    
    return response

  def deposit(self, amount: float, description: str = '') -> None:
    self.ledger.append({'amount': amount, 'description': description})
  
  def withdraw(self, amount:float, description:str = '') -> bool:
    if self.check_funds(amount):
      self.ledger.append({'amount': amount * -1, 'description': description})
      return True
    return False  
  
  def get_balance(self) -> float:
    total: float = 0
    for i in self.ledger:
      total += i["amount"]
    return float(total)

  def transfer(self, amount: float, target: type[Category]) -> bool:
    if not(self.check_funds(amount)):
      return False
      
    if self.withdraw(amount, "Transfer to " + str(target.name)):
      target.deposit(amount, "Transfer from " + str(self.name))
      return True
    return False

  def get_spendings(self) -> float:
    total: float = 0
    for i in self.ledger:
      if i["amount"] < 0:
        total += i["amount"]
        
    return total

  def check_funds(self, amount: float) -> bool:
    balance = self.get_balance()
    return amount <= balance
  
def create_spend_chart(categories: List[Category]) -> str:
  spent_totals: Dict[str, float] = {}
  spent_percen: Dict[str, float] = {}
  
  for c in categories:
    spent_totals[c.name] = c.get_spendings()

  for c in categories:
    spent_percen[c.name] = round(spent_totals[c.name] / sum(spent_totals.values()), 2) * 100

  chart: str  = "Percentage spent by category\n"
  for i in range(100, -10, -10):
    chart += str(i).rjust(3, ' ') + "|"
    for c, cval in spent_percen.items():
      if cval >= i:
        chart += " o "
      else:
        chart += "   "
    chart += " \n"

  chart += " " * 4
  for c in categories:
    chart += "-" * 3
  chart += "-\n"

  legend: str = ""
  
  legendlines = max(list(map(len, spent_percen.keys())))
  for line in range(legendlines):
    legend += " " * 4
    for c in spent_percen.keys():
      if len(c) > int(line):
        legend += " " + str(c)[line] + " "
      else:
        legend += " "  * 3
    legend += " \n"
        
  
  response = chart + legend.rstrip("\n")
  return response