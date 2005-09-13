#$Id$
#
# how to release a new version ::
# 
#  cvs tag <tag_name> *
# sh export_cvs.sh <tag_name>
#
#
#update the version in php file and here...
#
#
VERSION=$1

export CVSROOT="/home/sebhtml/cvs" #the root for cvs

CHANGE_LOG_FILE="Changelog.txt" #change log path

date > $CHANGE_LOG_FILE # jI put the date in it.

PROG_NAME="inicrond" #prog name

echo "$PROG_NAME $VERSION" >> $CHANGE_LOG_FILE

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

if test -d ../$PROG_NAME-$VERSION ; then #if the dir exists
rm -R ../$PROG_NAME-$VERSION #remove it
fi

mv $PROG_NAME ../$PROG_NAME-$VERSION #move it back.

cd .. #go back

rmdir export #remove the export dir 

cd $PROG_NAME-$VERSION #go in to the exported version

mv ../$CHANGE_LOG_FILE docs/ #move the change log

LINES_COUNT_FILE="docs/Lines_count.txt"

/usr/bin/php linescounter.php   --project . > $LINES_COUNT_FILE #to the linecount for fun.

cd .. # exit the new version directory.

#create the archives
#tar cvf $PROG_NAME-$VERSION".tar" $PROG_NAME-$VERSION #tar the fdir
#gzip -9 $PROG_NAME-$VERSION".tar" #gzip the file.
#md5sum $PROG_NAME-$VERSION".tar.gz" > $PROG_NAME-$VERSION".tar.gz.md5"

tar cvf $PROG_NAME-$VERSION".tar" $PROG_NAME-$VERSION #tar the fdir
bzip2 -9 $PROG_NAME-$VERSION".tar" #bzip2 the file.
md5sum $PROG_NAME-$VERSION".tar.bz2" > $PROG_NAME-$VERSION".tar.bz2.md5"

zip -r $PROG_NAME-$VERSION $PROG_NAME-$VERSION
md5sum $PROG_NAME-$VERSION".zip" > $PROG_NAME-$VERSION".zip.md5"
