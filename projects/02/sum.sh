#!/bin/bash

if [[ 2 -gt $# ]]; then
  echo 'Недостаточное количество аргументов.'
  exit 1
fi

sum=0
for i in "$@"; do
  if ! [[ $i =~ ^-?([0-9]+)([.][0-9]+)?$ ]]; then
    echo "Аргументы для суммирования должны быть вещественными числами: \"$i\" таковым не является."
    exit 1
  fi

  sum="$sum+($i)"
done

if command -v bc &> /dev/null; then
  echo "$sum" | bc -l | sed -r -e 's/^([-])?([.])/\10\2/';
  exit 0
fi

if command -v gnome-calculator &> /dev/null; then
  gnome-calculator -s "$sum"
  exit 0
fi

if command -v awk &> /dev/null; then
  echo | awk "{ print $sum }"
  exit 0
fi

echo "Для выполнения этой операции требуется установить один из пакетов: «bc», «gnome-calculator», «original-awk»."
exit 1
