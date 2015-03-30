_This document is old and hasn't been updated in awhile_

# Milestone 1 ![http://buy1.snapon.com/images/checkmark.gif](http://buy1.snapon.com/images/checkmark.gif) #
## Authoring ##
  * Course structuring tool
    * Overhauled to generic node model ([issue 1](https://code.google.com/p/gclms/issues/detail?id=1))
    * In Firefox, menu buttons now stay on top of page when scrolling through a long list of nodes
  * Integration of newest TinyMCE tool ([issue 8](https://code.google.com/p/gclms/issues/detail?id=8))
    * Popup linker/embedder of links/images/media ([issue 11](https://code.google.com/p/gclms/issues/detail?id=11))
  * Page authoring tool
    * Question of type "ordered list" ([issue 85](https://code.google.com/p/gclms/issues/detail?id=85))
    * Basic functionality for essay questions ([issue 82](https://code.google.com/p/gclms/issues/detail?id=82))
    * Improved responsiveness; no more waiting for Ajax calls
  * Pages and articles now can be viewed and linked to in non-framed environment; convenient links on these pages for immediate access to page authoring tool
## General Improvements ##
  * [UUIDs](http://en.wikipedia.org/wiki/UUID) now used for primary keys in all db tables
  * Reduced page loads from about 500k (4-8s) to 100-150k (2-4s)
    * Optimized sizes of commonly used images
    * Turned mod\_deflate functionality back on to reduce .js and .css file size
    * User now logs in with e-mail or student id; incipient functionality prepared for OpenID

# Milestone 2 #
## Print to English ##
  * Basic export-to-ODT functionality ([issue 2](https://code.google.com/p/gclms/issues/detail?id=2))
  * Export now includes some basic image functionality
  * User now prompted to download ODT immediately after clicking the export to ODT link
  * Shrink large images ([issue 74](https://code.google.com/p/gclms/issues/detail?id=74))
  * Table of contents / "bookmarks" for course structure ([issue 75](https://code.google.com/p/gclms/issues/detail?id=75))
  * Footer on every page after ToC ([issue 76](https://code.google.com/p/gclms/issues/detail?id=76))
  * Capable to Print in English ([issue 2](https://code.google.com/p/gclms/issues/detail?id=2))
## Authoring ##
  * Dictionary and article authoring interfaces now displayed more how students will see them; no longer displayed in tabular format
  * Answers to multiple choice questions now have TinyMCE-enabled explanations; students can be shown flash video or directed to page/article/chapter
  * Fixed: After clicking root node in course structure tool, clicking other nodes would not yield enabled menubar buttons ([issue 86](https://code.google.com/p/gclms/issues/detail?id=86))
  * Fixed: Parents with children on course structure page could be deleted in IE but not in Firefox
  * Fixed: A IE Javascript bug when indenting node
## General Improvements ##



# Milestone 3 #
## Print to Non-English ##
  * Print / Export to ODT in Chinese ([issue 83](https://code.google.com/p/gclms/issues/detail?id=83))
  * Print / Export to ODT in Arabic ([issue 84](https://code.google.com/p/gclms/issues/detail?id=84))
## Other ##
  * Fix and re-enable framed environment ([issue 62](https://code.google.com/p/gclms/issues/detail?id=62)) ([issue 81](https://code.google.com/p/gclms/issues/detail?id=81))

# Milestone 4 - Due May 2 #
## General Functions ##
  * **Introductory Material** ([issue 65](https://code.google.com/p/gclms/issues/detail?id=65))
  * **Registration/Logon/Logoff related** ([issue 33](https://code.google.com/p/gclms/issues/detail?id=33)) ([issue 60](https://code.google.com/p/gclms/issues/detail?id=60))
  * **Language related** ([issue 32](https://code.google.com/p/gclms/issues/detail?id=32))
  * **Communications related** ([issue 35](https://code.google.com/p/gclms/issues/detail?id=35))
  * **Personalization related** ([issue 36](https://code.google.com/p/gclms/issues/detail?id=36))
  * **Help related**  ([issue 34](https://code.google.com/p/gclms/issues/detail?id=34))
## Group Administration Functions ##
  * **Curriculum related**  ([issue 38](https://code.google.com/p/gclms/issues/detail?id=38))
  * **Authorizations related**  ([issue 31](https://code.google.com/p/gclms/issues/detail?id=31)) ([issue 37](https://code.google.com/p/gclms/issues/detail?id=37)) ([issue 39](https://code.google.com/p/gclms/issues/detail?id=39)) ([issue 40](https://code.google.com/p/gclms/issues/detail?id=40)) ([issue 69](https://code.google.com/p/gclms/issues/detail?id=69)) ([issue 70](https://code.google.com/p/gclms/issues/detail?id=70)) ([issue 71](https://code.google.com/p/gclms/issues/detail?id=71))
## Course Development Functions ##
  * ([issue 16](https://code.google.com/p/gclms/issues/detail?id=16))
  * **Authorizations related**   ([issue 15](https://code.google.com/p/gclms/issues/detail?id=15)) ([issue 31](https://code.google.com/p/gclms/issues/detail?id=31))
  * **Course Authoring related**  From Milestone 1 -([issue 1](https://code.google.com/p/gclms/issues/detail?id=1));  ([issue 20](https://code.google.com/p/gclms/issues/detail?id=20)) ([issue 18](https://code.google.com/p/gclms/issues/detail?id=18)) ([issue 23](https://code.google.com/p/gclms/issues/detail?id=23)) ([issue 24](https://code.google.com/p/gclms/issues/detail?id=24)) ([issue 27](https://code.google.com/p/gclms/issues/detail?id=27)) ([issue 19](https://code.google.com/p/gclms/issues/detail?id=19))
  * **Complementary Material related**  ([issue 25](https://code.google.com/p/gclms/issues/detail?id=25)) ([issue 26](https://code.google.com/p/gclms/issues/detail?id=26))
  * **Assignment/Question related** ([issue 17](https://code.google.com/p/gclms/issues/detail?id=17)) ([issue 30](https://code.google.com/p/gclms/issues/detail?id=30)) ([issue 7](https://code.google.com/p/gclms/issues/detail?id=7)) ([issue 6](https://code.google.com/p/gclms/issues/detail?id=6)) ([issue 24](https://code.google.com/p/gclms/issues/detail?id=24))  ([issue 22](https://code.google.com/p/gclms/issues/detail?id=22))
  * **Exam related** ([issue 28](https://code.google.com/p/gclms/issues/detail?id=28)) ([issue 29](https://code.google.com/p/gclms/issues/detail?id=29))
  * **Course Calendar related** ([issue 21](https://code.google.com/p/gclms/issues/detail?id=21)) ([issue 68](https://code.google.com/p/gclms/issues/detail?id=68))
## Facilitator Functions ##
  * ([issue 44](https://code.google.com/p/gclms/issues/detail?id=44)) ([issue 41](https://code.google.com/p/gclms/issues/detail?id=41))
  * **Class Development/Creation/Definition related** ([issue 45](https://code.google.com/p/gclms/issues/detail?id=45))([issue 43](https://code.google.com/p/gclms/issues/detail?id=43)) ([issue 42](https://code.google.com/p/gclms/issues/detail?id=42))
  * **Class Management related** ([issue 50](https://code.google.com/p/gclms/issues/detail?id=50)) ([issue 51](https://code.google.com/p/gclms/issues/detail?id=51))
  * **Gradebook related** - ([issue 58](https://code.google.com/p/gclms/issues/detail?id=58))
  * **Exam related** - ([issue 57](https://code.google.com/p/gclms/issues/detail?id=57))
  * **Authorizations related** ([issue 40](https://code.google.com/p/gclms/issues/detail?id=40)) ([issue 42](https://code.google.com/p/gclms/issues/detail?id=42)) ([issue 52](https://code.google.com/p/gclms/issues/detail?id=52)) ([issue 69](https://code.google.com/p/gclms/issues/detail?id=69)) ([issue 70](https://code.google.com/p/gclms/issues/detail?id=70)) ([issue 71](https://code.google.com/p/gclms/issues/detail?id=71))
  * **Evaluations related** ([issue 46](https://code.google.com/p/gclms/issues/detail?id=46)) ([issue 49](https://code.google.com/p/gclms/issues/detail?id=49))
  * **Class Calendar related** - ([issue 53](https://code.google.com/p/gclms/issues/detail?id=53))([issue 54](https://code.google.com/p/gclms/issues/detail?id=54)) ([issue 55](https://code.google.com/p/gclms/issues/detail?id=55))
  * **Attendance book related** - ([issue 59](https://code.google.com/p/gclms/issues/detail?id=59))
## Student Functions ##
  * From Milestone 2: ([issue 13](https://code.google.com/p/gclms/issues/detail?id=13))
  * ([issue 3](https://code.google.com/p/gclms/issues/detail?id=3))
  * **Authorizations related** ([issue 71](https://code.google.com/p/gclms/issues/detail?id=71)) ([issue 72](https://code.google.com/p/gclms/issues/detail?id=72)) ([issue 73](https://code.google.com/p/gclms/issues/detail?id=73))
  * **Evaluations related** ([issue 47](https://code.google.com/p/gclms/issues/detail?id=47))
  * _**Life Notebook related**_ ([issue 61](https://code.google.com/p/gclms/issues/detail?id=61)) ([issue 4](https://code.google.com/p/gclms/issues/detail?id=4))
# e-commerce integration (low priority) #

# Miscellaneous / Unsorted #
  * Add Tiny MCE English spellchecker ([issue 5](https://code.google.com/p/gclms/issues/detail?id=5))
  * Ability to delete media files ([issue 77](https://code.google.com/p/gclms/issues/detail?id=77))
  * Fix drag & drop "ghosting" error in IE ([issue 79](https://code.google.com/p/gclms/issues/detail?id=79))
  * Ability to pick up where one last left off in a course ([issue 80](https://code.google.com/p/gclms/issues/detail?id=80))
  * E-commerce integration ([issue 9](https://code.google.com/p/gclms/issues/detail?id=9))
  * Unexpected behavior when decreasing indent of node ([issue 63](https://code.google.com/p/gclms/issues/detail?id=63))