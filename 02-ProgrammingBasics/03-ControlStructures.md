# Control Structures
Control structures control the flow of a program.

If we assume the following variables

* *variable a* is an integer equal to **1**
* *variable b* is a string equal to '**hello**'
* *variable c* is an array (or set) with the following elements
    * **Hello**
    * **World**
    * **dog**
    * **cat**
    * **mouse**

Based on the aforementioned variables some basic control structures might look like the following

* While *variable a* is less than **7**, call some arbitrary block of logic and increment *variable a* by **1**.
* If *variable a* exists as **an element** of *variable b*, then return **true**, else return **false**.
* foreach *element* in *variable c*, check to see if that **element** is equal to the *variable b*.

## Comparison Operators

As mentioned - PHP, BASH and JavaScript are all dynamically typed meaning the type changes to try to fit a context. Meaning the value of integer 1 and string 1 are the same. So 1 == '1' evaluates to true, in this case the double equals sign says is the value of integer 1 string 1 the same? In contrast 1 === '1' evaluates to false, this asks does string 1 and integer 1 have the same value and data type?  

* ```==``` - equal to, value only
* ```===``` - equal to, value and type
* ```>``` - greater than
* ```<``` - las than
* ```>=``` - greater than or equal to
* ```<=``` - less than or equal to

For the following statments assume a = 0 and b = 1

>```=``` is an assignment operator,```==``` is a comparison operator.

* a == b //false
* a < b //true
* a > b //false
* a == 0 //true
* a == '0' //true
* a === '0' /false
* a >= 0 //true
* a <= 0 //true

### Conditional Statements
* if/if-then - If a condition is (or is not) met, then do something
* if-else/if-then-else - If a condition is (or is not) met, then do something. Otherwise, do something else.
* switch - Execute something depending on the state of a given condition.

```php
var $a=1;

//if/if-then
if($a === 1){
    echo 'Match!';
}

//if-then/if-then-else
if($a === 1){
    echo 'Match!';
}else{
    echo 'Mot a match';
}

//switch
switch($a){

    case 1:
        echo 'One';
        break;

    case 2:
        echo 'Two';
        break;

    default:
        echo 'Unknown Number';
        break;

}
```

```js
var a=1;

//if/if-then
if(a === 1){
    echo 'Match!';
}

//if-then/if-then-else
if(a === 1){
    echo 'Match!';
}else{
    echo 'Mot a match';
}
```

```bash
a=1;

#if/if-then
if [ "$a" == 1 ]
then
    echo 'Match!';
fi

#if-then/if-then-else
if [ "$a" == 1 ]
then
    echo "Match!"
else
    echo "Mot a match"
fi
```

## Loops
* for - executes a fixed number of repetive operations
* foreach/for-in/for-of - executes a repetive operation for each element in a set
* while - executes a repetive operation while a condition is (or is not) true. Requires 1 truth prior to execution.
* do-while - executes a repetive operation while a condition is (or is not) true. Executes prior to first truth. 

```php

//Iterate a set number of times
for($i=0; $i<10; $i++){
    echo $i++;
}

//Iterate over each item of an array
$items = [1,2,3,4,5,6,7,8,9];

foreach($items as $item){
  echo $item;
}

//Test then execute
$i = 0;
while ($i <= 10) {
    echo $i++;
}

//Execute then test
$i = 11;
do {
    echo $i++;
}while ($i <= 10);
```

```js
//Iterate over an object
var obj = {a: 1, b: 2, c: 3};
for (var prop in obj) {
  console.log(prop);
}

//Iterate over an array
let array = [10, 20, 30];
for (let el of array) {
  console.log(el);
}
```

```bash
#!/bin/bash

ITEMS=( 1 2 3 4 5 5 6 7 8 9 )

# Classic for loop
for ((i=0; i<${#ITEMS[*]}; i++));
do
    echo ${ITEMS[i]}
done

# For in - special array loop
for ITEM in "${ITEMS[@]}"
do
  echo "$ITEM"
done

# While loop
STRING=''
while [ "$STRING" != "Hello World" ]
do
    if [ -z  "$STRING" ]
    then
      STRING="Hello"
    else
      STRING="${STRING} World"
    fi
done

echo "$STRING"
```