#$Id: indent-gnu-style.sh 143 2006-08-17 22:34:17Z sebhtml $


# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Library General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.

#synopsis :
#indent-gnu-style.sh  

indent_files_in_dir()
{
cd $1 #go to the asked directory

indent -gnu-style *.php #indent stuff

perl -p -i -e 's/^< \? php$/<?php/g' *.php #change < ? php to <?php
perl -p -i -e 's/^\? >$/?>/g' *.php #   change ? > to ?>
perl -p -i -e 's/\. =/ .= /g' *.php #   . = to .=


rm *~ #remove those ugly files
}


indent_files_in_dir $1


