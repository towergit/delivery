#!/bin/bash

# while [  $RESULT -eq 1 ]; do

#RESULT=$(php yii_console.php mailing send)
#if [ $result -eq 1 ]; then
#    echo OK
#else
#    echo FAIL
#fi
        OFFSET=0;
        RESULT=0
        
  if [ ! "$1" ];
    then
    echo 'need passing first param name of tamplate';
    exit 1
    fi;
    

  while [  $RESULT -eq 0 ]; do
            RESULT=$(php yii_console.php mailing send --template=$1 --offset=$OFFSET)
            echo "$OFFSET - $RESULT"
            OFFSET=$((OFFSET + 100))
         done
