rss-orbit
=========
version 0.5

A application that creates slideshow by fetching images from feeds, stores feed links in sidebar and can download 
pdf of current slideshow. 

A responsive rss feed reader using foundation framework(css), backbonejs framework(localstorage and events) and php for 
feed reader engine and image resizing.

User can enter url. If its a webpage, rss-orbit app will parse through it and will get rss feed link. And if rss feed url 
then it will directly start parsing it and will fetch title, discription(not more than 150 chars) and images(resized to 
180x180px). Fetched data will be shown in slideshow using Foundation's Orbit.

Sidebar will store entered urls using localstorage. All the url data is handled with backbonejs framework. Slideshow will
be of latest url entered. If any url stored in siderbar is clicked, its slideshow will start. 

Comming soon- 'GET PDF' for downloading pdf of currnet slideshow, validations, and more powerful feed reader engine.
