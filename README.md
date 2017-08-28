# Trumpia API #
Trumpia API enables users to seamlessly integrate our technologies into their application. And with high throughput rates, a free shared short code, and included web-based user interface, we offer a complete and unmatched suite of SMS messaging functionalities. This is just one of those many powerful use cases, but you can learn about them all at our website.

[Trumpia Home Page](https://trumpia.com)

[REST API Documentation](http://api.trumpia.com/docs/rest/overview.php)

# Overview #
This PHP application example demonstrates how to implement `PUT` and `POST` Authentication and `GET` REPORT using Trumpia's RESTful API. Authentication is a great tool to verify a recipients phone number. The HTML web page utilizes Bootstrap for the theme and design. This simplifies the page and makes it responsive.

Bootstrap can be installed multiple ways, but the code has been included into the sample code between the `<head>` tags. Feel free to make adjustments to change the look and feel. Visit [GetBootStrap](https://getbootstrap.com/docs/4.0/getting-started/introduction/) to learn more.

#### Languages: ####
1. PHP 5.6.22
2. HTML5 & Bootstrap
3. Javascript

#### REST API functions used: ####
1. PUT Authentication
2. POST Authentication
3. GET Report

#### Information collected on web form: ####
1. Mobile number

# Application Workflow #
The web form collects the user�s mobile number and sends a unique verification code via SMS that is used to validate the phone number. Once the user enters the data, the application will check the status of the request. HTML5 along with Javascript is used for input data validation, and the request if then checked with our REST API function GET REPORT.

The files included are:
1. index.php - home page that collects user�s information.
2. verification.php - page where the user enters the verification code to verify their phone number.
3. complete.php - simple thank you page.
4. authentication.php - PHP page that has the two-factor authentication and status report functions.
5. request_rest.php - PHP page that contains CURL functions.

The user will receive a Javascript confirmation pop-up if:
1. The verification is successful
2. The verification fails


# Understanding Status Codes #
Descriptions of the different status code(s) can be found within the [authentication status code documentation](http://trumpia.com/api/docs/rest/status-code/authentication.php). Common status codes for the authentication function:
* **MRME0551:** Mobile number is blocked. *Resolution: Have the end user text HELP to the short code to remove the block and allow short code messaging.*
* **MRCE0000:** Verification successful
* **MREE2551:** Verification failed, please check verification code.

#### Need some help? Found a bug? Please email [apisupport@mytrum.com](mailto:apisupport@mytrum.com) with any questions! ####
