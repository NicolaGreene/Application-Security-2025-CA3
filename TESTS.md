This file contains the instructions of how to run the security tests conducted as per the technical report.

SAST:
-Using Snyk (web app), this GitHub repository was linked and scanned. 
-From there results were listed on the web app. 
-This test was repeated multiple times but most prominently before and after implementation.

DAST:
-Using OWASAP ZAP, the URL to the running web application was inputted.
-AJAX spider was changed to use Chrome (browser used while testing).
-Attack was started.
-Results were listed and generated into a separate PDF report.
-This was repeated before and after implementation.

SQL injection:
-payload “ OR 1=1 -- “ was used as the password in the login

XSS:
-payload ("><script>alert(1)</script>) was used in an echo request

Workflow:
-Add items form (admin page) was used with the following name, price and an image
- "     "(5 spaces), "-1", no image
- "tests", " "(space), valid image

Error Handling:
-Using workflow test ^, test was repeated until an error appeared.

Access Control:
-“/accounts/admin.php" was added to end of URL from both home page (not logged in) and logged in as a customer

