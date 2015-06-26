#!/bin/bash
 
# カレントディレクトリをファイルの場所に変更
cd `dirname $0`
 
#ファイル名の入力を待つ
echo -n "縦横共通仕上がりサイズ(px)※仕上がりは全部png:"
read size

echo 'Start Time: '
echo `date '+%Y/%m/%d'`
echo `date '+%H:%M:%S'`

#カレントjpg/png/gif読み込み
for i in $(find ./ -name "*.png" -o -name "*.jpg" -o -name "*.jpeg" -o -name "*.gif" -o -name "*.PNG" -o -name "*.JPG" -o -name "*.JPEG" -o -name "*.GIF");
do
	A=`basename $i | sed -e 's/.png//'`
	B=`basename $A | sed -e 's/.jpg//'`
	C=`basename $B | sed -e 's/.jpeg//'`
	D=`basename $C | sed -e 's/.PNG//'`
	E=`basename $D | sed -e 's/.JPG//'`
	F=`basename $E | sed -e 's/.JPEG//'`
	G=`basename $F | sed -e 's/.GIF//'`

	sips -z  ${size} ${size} ${i} --out ${G}.png
done

echo 'End Time: '
echo `date '+%Y/%m/%d'`
echo `date '+%H:%M:%S'`