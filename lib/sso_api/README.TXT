
The scripts in the folders /domain1/ and /domain2/ must be executed from disctinct domains, i.e. :

	* http://www.domain-one.com/	for the scripts in the folder /domain1/ 
	* http://www.domain-two.com/	for the scripts in the folder /domain2/ 
	

To test SSO, first create the SSO session:

	* http://www.domain-one.com/sso_api/domain1/start_sso_session.php
	

Then go to domain2 and check if it's recognized

	* http://www.domain-two.com/sso_api/domain2/check_sso_session.php