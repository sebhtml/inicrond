#This greate script automate the back-up process.
#$Id$

__HOME_PATH__=/home/sebhtml/

remove_a_file_if_it_exists()
{
__FILE__=$1
echo "Check if "${__FILE__}" exists"
if test -e ${__FILE__}
then
echo ""${__FILE__}" exists and will be removed"
rm ${__FILE__}
else
echo ""${__FILE__}" does not exists"
fi

}
#problem with thread???

remove_a_file_if_it_exists ${__HOME_PATH__}cvs.tar

echo "Taring the file"
tar cvf ${__HOME_PATH__}cvs.tar ${__HOME_PATH__}cvs # create a tar.

remove_a_file_if_it_exists ${__HOME_PATH__}cvs.tar.bz2

echo "Compressing ther file"
bzip2 ${__HOME_PATH__}cvs.tar # compress the file.

back_up_on_a_device()
{
__FILE__=$1
__DEVICE__=$2
__PATH_ON_DEVICE__=$3
  
mount ${__DEVICE__}
echo ${__DEVICE__}" is mounted"
echo ${__FILE__}" will be copied on "${__PATH_ON_DEVICE__}

#remove the file if it exists.

if test -e ${__PATH_ON_DEVICE__}${__FILE__}
then
rm ${__PATH_ON_DEVICE__}${__FILE__}
fi

cp ${__FILE__} ${__PATH_ON_DEVICE__}
echo "The file was copied succesfully"
umount ${__DEVICE__}
echo ${__DEVICE__}" was umounted"
}

#samsung
#back_up_on_a_device ${__HOME_PATH__}cvs.tar.bz2 /dev/hda5 /mnt/hda5/sda1/dev/cvs/

# copy it on the maxtor
#back_up_on_a_device ${__HOME_PATH__}cvs.tar.bz2 /dev/hdb6 /mnt/hdb6/sda1/dev/cvs/

# copy it on the universal smart drive.
back_up_on_a_device ${__HOME_PATH__}cvs.tar.bz2 /dev/sda1 /mnt/usb-drive/dev/cvs/

# copy it on the universal smart drive.
#back_up_on_a_device ${__HOME_PATH__}cvs.tar.bz2 /dev/sdb1 /mnt/cam/dev/cvs/
