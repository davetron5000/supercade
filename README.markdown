# Supercade's Website 

This is my old band's website (no longer up), which, I suppose, someone else could easily customize to make their own band website. 

The idea was to not have to host things like images (use Flickr) and to not have to maintain two "news" things (one on myspace, one on the site).

So, the general features are:

* Updates on band's myspace show up in the "news" section
* Pictures section uses pix from flickr, based on tags on flickr
* Upcoming shows is database driven
* Past shows are separated via the database

Nothing special, but it works reasonably well and, more importantly, is my attempt at some PHP that isn't a pile of procedural crud.

# Database 

As a shittly local band, we end up playing at the same venues with the same bands, so I figured, for maximum laziness, I could enter in this stuff one time only and have the site just link it all up.  Also, this can be used to link to google maps and stuff, so the site is actually marginally useful (and moreso than myspace, since it's dog slow and doesn't link to maps [or at least didn't, as of 2005]).

![Data Model](http://www.gliffy.com/pubdoc/1409661/L.jpg "Data Model") [link](http://www.gliffy.com/pubdoc/1409661/L.jpg)

Nothing too complicated, but obviously there's a join table in there between `SHOW` and `BAND`.

I also had fields in there to keep track of our draw, so we could see depressing charts like this:

![Our paltry fan base](http://spreadsheets.google.com/pub?key=prolwQzHjVoG6PLj8fY2ONg&oid=2&output=image "Our paltry fan base")

# Admin Interface

Um, yeah.  It was phpMyAdmin for all intents and purposes.  In fact, the site original had the pictures and news hosted from the database and I was too lazy to make a real admin interface, so I figured the *true* lazy way was to use Flickr and MySpace instead.  Fortunately, that worked out pretty well.
