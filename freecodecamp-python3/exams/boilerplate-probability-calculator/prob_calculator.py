import copy
import random
from itertools import repeat
from typing import List, Dict
from collections import Counter

# Consider using the modules imported above.
class Hat(object):
  
  #*args, **kwargs typehinting
  #** always binds to a dict with string keys,
  #   Because of this restriction, type hints only need you to define the types of the contained arguments
  #@see https://adamj.eu/tech/2021/05/11/python-type-hints-args-and-kwargs/
  
  def __init__(self, **keyvalueargs1: int) -> None:
      #self.contents: dict = dict(**keyvalueargs1)
      self.contents: List[str] = list()
      for ballcolor, ballcount in keyvalueargs1.items():
        for _ in range(ballcount):
          self.contents.append(ballcolor)
          
  def draw(self, amount: int) -> List[str]:
    if amount > len(self.contents):
      return self.contents
    
    #Random sampling without replacement
    #@see https://note.nkmk.me/en/python-random-choice-sample-choices/
    result = random.sample(self.contents, amount)
    
    #Remove picked values from the population
    for i in result:
      self.contents.remove(i)

    return result

def experiment(hat: Hat, expected_balls: Dict[str, int], num_balls_drawn: int, num_experiments: int) -> float:

  hits: int = 0


  for _ in range(num_experiments):
    #run experiment on copy of dataset
    tmpHat = copy.deepcopy(hat)
    isHit:int = 1
    
    drawraw = tmpHat.draw(num_balls_drawn)
    drawcount = Counter(drawraw)
    for ballcolor, ballcount in expected_balls.items():
      if drawcount[ballcolor] < ballcount:
        isHit = 0
        break
    
    if isHit == 1:
      hits = hits+1
      
  return hits/num_experiments
