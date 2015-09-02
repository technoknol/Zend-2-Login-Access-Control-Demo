ZendFramework 2 Demo Application
================================

# Introduction

This started as a simple ZF2 demo login/logout (with access control) application
example. But, it has been expanded with other features.

A live example is available at http://zf2demo-dawningstreams.rhcloud.com/ 

## General Structure

The structure of the code is based on the ZF2 skeleton application. However,
the Application module has been replaced with a *Main* module.

- The code contains explanatory comments not mentioned here.
- Controllers depending on services are created with factories.
- The *index* controller handles the home page.

## Login/Logout & Access Control

A login system with access control has been implemented without the use of a 
database. The login form is available on the home page and is displayed with
the help of a view helper called *LoginWidget*.

Two controllers, three services and one model have been created:

- The *authentication controller* deals with login (i.e. authentication) and
logout requests.
- The *access controller* makes sure proper roles are owned to
access restricted pages.
- The *authentication adaptor* checks usernames and passwords, and
assign roles.
- The *user session storage* service stores session information between HTTP requests.
- The *login/logout service* is the mediator between the authentication controller,
the access controller, the authentication adapator and the user session service.
- The *user model* is helps creating creating the login form.

This code is remotely inspired from Samsonasik's
[code example](https://samsonasik.wordpress.com/2012/10/23/zend-framework-2-create-login-authentication-using-authenticationservice-with-rememberme/).
It has been significantly refactored and extended.

## Roll A Dice Service

In order to demonstrate the use of a roundtrip and of Ajax to call
a service, a roll-a-dice service has been implemented.

- The *roll-a-dice controller* handles request to the service.
- The *roll-a-dice service* provides a random number between 1 and 6.

Both means to throw a dice are available in the corresponding service page
which contains some Javascript using JQuery.

## Testing

Some PHP unit tests for controllers and the roll-a-dice service have been
implemented. They do not cover all code.
