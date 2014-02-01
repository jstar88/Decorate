Decorate
========

A PHP class usefull to decorate functions


## Introduction

This class represent the beginning of functional programming in PHP.  
The decorator patter can easly make your application modular while functions transform it in to an event-driven application.  

The goal of this class is to decorate functions, taking advantage of objects to make a queue-like structure and store in it partial results and functions.

Note that with the other my class https://github.com/jstar88/Editable it can show you a full dynamic decorated system usefull, for example, for a plugin system 


## Usage

Usage it's pretty easy: require the main class

```php 
 require "Decorate.php";
 ```
 
 and then you can use its 2 methods:
 
### onBefore
 
 ```php
 $function = Decorate::onBefore($function, $newFunction);
 ```
 
 Where
 
 * ```$function``` is the callable function to intercept
 * ```$newFunction``` is the callable function that will be called before the other one.Note that the arguments of this function are the same of ```$function```, in this way you have all the things usefull to build your interceptor-logic
 * the method return a ```FunctionEmulator``` class
 
### onAfter
 
 ```php
 $function = Decorate::onAfter($function, $newFunction);
 ```
 
Where
 
 * ```$function``` is the callable function
 * ```$newFunction``` is the callable function that will be called after the other one.Note that the argument of this function is just the return of the other function
 * the method return a ```FunctionEmulator``` class
 
### the return: FunctionEmulator

This object is really a function emulator and you can use it as a standard function, but you also call its method!  
Expecially you can use this object to decorate him again like a callable function.  
Not only,it's a object where inside are stored the original function and the new one.  You can use these methods:

* ```getPreReturn()```: this function can be called with how many arguments you want and they are the same arguments of your main function to call.  
It will return the original function return.

* ```getParent()```: this function will return the original function or older FunctionEmulator. In this way you can iterate on the history and find all the result of aggregated functions. 


