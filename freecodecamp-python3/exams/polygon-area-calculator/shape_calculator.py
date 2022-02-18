from __future__ import annotations
from abc import ABC, abstractmethod
from math import floor

class Shape:
  
  def __init__(self) -> None:
    self.width = 0
    self.height = 0
  
  @abstractmethod
  def __str__(self) -> str:
    pass
  
  def get_picture(self) -> str:
    if self.height > 50 or self.width > 50:
      return 'Too big for picture.'
    
    result: str = ""
    for line in range(self.height):
      result += "*" * self.width + "\n"
    return result
  
  @abstractmethod
  def get_area(self) -> int:
    pass
  
  def get_amount_inside(self, smallShape: Shape) -> int:
    selfSize = self.get_area()
    smallShapeSize = smallShape.get_area()
    return floor(selfSize / smallShapeSize)
  

class Rectangle(Shape):

  def __init__(self, width: int, height: int) -> None:
    self.width = width
    self.height = height

  def __str__(self) -> str:
    return str(type(self).__name__) + "(width={0}, height={1})".format(self.width, self.height)

  def set_width(self, width:int) -> None:
    self.width = width

  def set_height(self, height:int) -> None:
    self.height = height

  def get_area(self) -> int:
    return self.height * self.width

  def get_perimeter(self) -> int:
    return 2 * self.width + 2 * self.height

  def get_diagonal(self) -> float:
    return (self.width ** 2 + self.height ** 2) ** 0.5

class Square(Rectangle):
  
  def __init__(self, side: int) -> None:
    self.width = side
    self.height = side
      
  def __str__(self) -> str:
    return str(type(self).__name__) + "(side={0})".format(self.width)
  
  def set_width(self, width:int) -> None:
    self.width  = width
    self.height = width

  def set_height(self, height:int) -> None:
    self.height = height  
    self.width  = height
    
  def set_side(self, side:int) -> None:
    self.height = side  
    self.width  = side    
    
