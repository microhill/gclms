# Version 0.3 #

### September 8-15, 2008 ###

  * urlencoded key for s3 thumbnail creation; problem with uploading files which have ampersands still remain
  * Chat functionality added
  * Seemingly fixed indent bugs that were causing the need for the clean\_up script in course structure
  * Visual database schematics updated
  * Fixed book editor. Users may again create,remove,update,delete chapters

### September 1-7, 2008 ###

  * Fixed various bugs in site administration
  * Fixing bug caused by page-save when a question doesn't have supplied possible answers
  * Sorry, having updated this list in awhile...
  * Forum functionality added

### August 25-31, 2008 ###

  * Added basic notebook entry ability
  * Fixed bug: "View without frames" link wasn't working

### August 18-24, 2008 ###

  * Fixed bug: explanation for fill-in-the-blank wasn't working
  * Fixed bug: couldn't delete possible answers in editor if question was fill-in-the-blank
  * Fixed bug: "undefined" showing instead of translated phrases for questions when in framed mode

### August 11-17, 2008 ###

  * Bible section works again on the framed classroom; uses bibleapi.net
  * All self-assessment questions and answers rendered on student-side now
  * Various bug fixes
  * Removed redirect-to-s3-file in favor of direct url in open courses
  * Fixed export-to-ODT bug caused by migration of media storage to S3
  * Fixed bug: focus was automatically going to first input element, but sometimes this required auto-scrolling to the middle of the page

### July 28 - August 8, 2008 ###

  * Media files now stored remotely on Amazon's S3 storage service
  * Books, articles, glossary terms working in framed classroom environment
  * Sorry, haven't been keeping up with the changelog

### July 20-26, 2008 ###

  * Framed classroom re-enabled and made it visible
  * Fixed bug ([issue 119](https://code.google.com/p/gclms/issues/detail?id=119)): Lesson navigation collapse/expand buttons not working (in framed classroom)
  * Lots and lots of more bug fixes...
  * Improved image thumbnail caching; improved image pop-up display

### July 13-19, 2008 ###

  * Fixed bug ([issue 116](https://code.google.com/p/gclms/issues/detail?id=116)): Unable to modify answer titles
  * Fixed bug ([issue 118](https://code.google.com/p/gclms/issues/detail?id=118)): Save button doesn't work after creating then deleting answer to multiple choice
  * Enhancement: smarter generation of links to account for extended classroom URLs

### July 6-12, 2008 ###

  * Fixed bug ([issue 113](https://code.google.com/p/gclms/issues/detail?id=113)): HTML carries over to multiple fill-in-the-blank answers
  * Enhancement: Edit functionality added to classes management.
  * Fixed bug ([issue 113](https://code.google.com/p/gclms/issues/detail?id=113)): Various navigation issues
  * Fixed bug ([issue 115](https://code.google.com/p/gclms/issues/detail?id=115)): Glossary terms not linking correctly within pages
  * Fixed bug ([issue 116](https://code.google.com/p/gclms/issues/detail?id=116)): Course URL's shouldn't retain single quote