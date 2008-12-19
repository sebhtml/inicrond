#$Id: export_cvs.sh 143 2006-08-17 22:34:17Z sebhtml $

VERSION=$1

export CVSROOT=":ext:sebhtml@cvs.sf.net:/cvsroot/inicrond" #the root for cvs

CHANGE_LOG_FILE="ChangeLog" #change log path

date > $CHANGE_LOG_FILE # jI put the date in it.

PROG_NAME="inicrond" #prog name

echo "$VERSION" >> $CHANGE_LOG_FILE

./cvs2cl.pl --hide-filenames --tags --stdout >> $CHANGE_LOG_FILE #do the Changelog

#/usr/bin/php remove_date.php --input $CHANGE_LOG_FILE #remove the date from the changelog...

#kate $CHANGE_LOG_FILE #modify the changelog..., remove old stuff..


mv $CHANGE_LOG_FILE .. #move the change log so it is not taggued



cd .. #go back and export the sfotware..

if test -d export ; then #if the dir exists
rm -R export
fi

mkdir export
cd export



cvs export -r $VERSION $PROG_NAME  #export the tag

 #la version.

DIR_NAME=$VERSION

if test -d ../$DIR_NAME ; then #if the dir exists
rm -R ../$DIR_NAME #remove it
fi

mv $PROG_NAME ../$DIR_NAME #move it back.

cd .. #go back

rmdir export #remove the export dir

cd $DIR_NAME #go in to the exported version

mv ../$CHANGE_LOG_FILE . #move the change log


cd .. # exit the new version directory.

#create the archives
tar cvf $DIR_NAME".tar" $DIR_NAME #tar the fdir
gzip -9 $DIR_NAME".tar" #gzip the file.
md5sum $DIR_NAME".tar.gz" > $DIR_NAME".tar.gz.md5"

tar cvf $DIR_NAME".tar" $DIR_NAME #tar the fdir
bzip2 -9 $DIR_NAME".tar" #bzip2 the file.
md5sum $DIR_NAME".tar.bz2" > $DIR_NAME".tar.bz2.md5"

zip -r $DIR_NAME $DIR_NAME
md5sum $DIR_NAME".zip" > $DIR_NAME".zip.md5"
