# $Id$




INSERT INTO sebhtml_options
(
news_forum_discussion_id, 

usr_time_decal,

preg_email,
 preg_usr, 
 preg_agent,
language,
titre,
separator,
header_txt,
footer_txt
)
VALUES
(
 1,

  -8,

'/^[a-zA-Z0-9_.-]{1,}@[a-zA-Z0-9_.-]{1,}[a-zA-Z]$/i',
 '/[a-zA-Z0-9_]{4,16}/',
  '/google|msn|php/i',
  'fr',
  'Titre',
  '/',
  '',
  ''
  )
;
#--------------------------------------------------------------------------------------------------------------

