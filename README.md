# Description #
This project is an example of a Zend Application which can use a combination of external login providers (Facebook, Twitter, Google) to perform authentication and use their API's.

## Instructions ##
### Step 1 ###

To clone this repository, do the following:

~~~
git clone --recursive git://github.com/thebestsolution/ZendMultipleAuthentications DESTINATION
cd DESTINATION
~~~

If you have PHP version < 5.3 (no namespace support):

~~~
git checkout no_namespaces
git submodule update
~~~

### Step 2 ###
You also have to download the Zend framework. I only tested the application with Zend Framework version 1.11.11 ([link](http://framework.zend.com/releases/ZendFramework-1.11.11/ZendFramework-1.11.11-minimal.zip)), but it should work with older versions. If you have any trouble place a [comment](http://thebestsolution.org/zend-login-with-facebook-twitter-and-google/#respond).

Unpack the archive and copy the Zend folder to the library folder of the checked out repository folder.

### Step 3 ###
Change the `application.ini` (can be found in application/configs), to your configuration.

Change YOUR_HOSTNAME with the server name of your vhost. If your app doesn't run at the siteroot you have to change some stuff in the `Bootstrap.php`. If you need any help place a [comment](http://thebestsolution.org/zend-login-with-facebook-twitter-and-google/#respond)

* Facebook API settings

~~~
facebook.client_id      = "xxxx"
facebook.client_secret  = "xxxx"
facebook.redirect_uri   = "http://YOUR_HOSTNAME/login/facebook"
facebook.scope          = "email"
~~~

The `client_id` and `client_secret` can be found at https://developers.facebook.com/apps

On the Facebook [site](https://developers.facebook.com/apps) set the Site URL to http://YOUR_HOSTNAME/

The different scopes can be found at https://developers.facebook.com/docs/reference/api/permissions/

* Google API settings 

~~~
google.client_id        = "xxxx"
google.client_secret    = "xxxx"
google.redirect_uri     = "http://YOUR_HOSTNAME/login/google"
google.scope            = "https://www.googleapis.com/auth/userinfo.profile"
~~~

The `client_id` and `client_secret` can be found at https://code.google.com/apis/console

On the Google [site](https://code.google.com/apis/console) set the Redirect URI to http://YOUR_HOSTNAME/login/google

I could not find a list with all the available scopes, you just have to google for it.

* Twitter API settings

~~~
twitter.consumerKey     = "xxxx"
twitter.consumerSecret  = "xxxx"
twitter.callbackUrl     = "http://YOUR_HOSTNAME/login/twitter"
~~~

The `consumerKey` and `consumerSecret` can be found at https://dev.twitter.com/apps

On the Twitter [site](https://dev.twitter.com/apps) set the Callback URL to http://YOUR_HOSTNAME/login/google

## More ##
A blog post about the subject at http://thebestsolution.org/zend-login-with-facebook-twitter-and-google
