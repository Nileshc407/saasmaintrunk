<?php $this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}		
$Photograph = $Enroll_details->Photograph;
if($Photograph=="")
{
	$Photograph=base_url()."assets/images/profile.jpg";
} else {
	$Photograph=$this->config->item('base_url2').$Photograph;
}
?> 
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/settings';"><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Terms & Conditions</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>

<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 termsPrivacyWrapper">
				<p>Please read these Terms and Conditions of use carefully before using this mobile application (the “App”). By accessing or using this App or any functionality thereof on any computer, mobile phone, tablet, console or other device (together “Devices” and each a “Device”), you confirm that you have read, understood and agreed to be bound by these Terms and Conditions of Use and any other applicable law. If you do not agree to these Terms and Conditions of Use, please do not access or use the App or any functionality thereof.</p>
                <ul class="termsMain">
					<h3>Owner and Operator Information</h3>
					<li>The App is owned, operated and provided by Nairobi Java House Limited, a company existing under the laws of Kenya, with its registered office at ABC Place, off Waiyaki Way Nairobi (“Java House”).</li>
					<li>For the purpose of these Terms and Conditions of Use, any reference to “Java House”, “we” or “us” may be a reference to Java House affiliated companies or business names.</li>
					<h3>Authorised Users and Loyalty Points</h3>
					<li>This App is intended for Java House customers.</li>
					<li>In order to use certain current or future functionalities of this App, you will be required to register or sign in as a loyalty customer or to create an account.</li>
					<li>A Java House customer must present their mobile phone number at the time of purchase to earn points. No points will be awarded retrospectively.</li>
					<li>A customer will earn KES. 2.00 for every KES 100.00 spent.</li>
					<li>Where a Customer obtains sufficient points, such points may be redeemed at any given time by the Customer by the Customer presenting their mobile phone number at the time of purchase and payment at any of the outlets participating in the loyalty scheme. Points cannot be redeemed for cash.</li>
					<li>Redemption value of points is currently at KES. 1.00 per point. We reserve the right to review and/or modify this criteria at our own sole discretion and without requirement for notice.</li>
					<li>Java House reserves the right to change the redemption criteria and/or exclude any items or services from the loyalty scheme and hence loyalty points may not be awarded for purchases of such goods and/or services.</li>
					<li>A Customer may inquire from the App on the number of points credited to the Customer’s account or the account balance.</li>
					<li>Java House can, at its own discretion, modify the loyalty programme rewards without notice save for updates and reviews to these Terms and Conditions where need be at its own discretion.</li>
					<li>Java House reserves the right to discontinue membership or an account and void a Customer’s point balance and rewards if any unauthorized points are earned or redeemed, or if there is any unauthorized use of the App or loyalty programme.</li>
					<h3>Use and Unacceptable Use of the Application</h3>
					<li>You may not do the following in relation to the Content of this App:
						<ul class="trems">
							<li>copy (whether by printing off onto paper, storing on disk, downloading or in any other way), distribute (including distributing copies), broadcast, alter or tamper with in any way or otherwise use any material contained in the App. These restrictions apply in relation to all or part of the Content;</li>
							<li>remove any copyright, trade mark or other intellectual property notices contained in the original material from any material copied or printed off from the App;</li>
							<li>link to the App;</li>
							<li>use the App or any part of it in any unlawful manner, for any unlawful purpose, or in any manner inconsistent with these Terms and Conditions of Use, or act fraudulently or maliciously, for instance by hacking into or inserting malicious codes, including viruses, or harmful data, into the App or any operating system;</li>
							<li>use the App in a way which could damage, disable, overburden, impair or compromise Java House’s systems or security or interfere with other users;</li>
							<li>collect or harvest any information or data from the App or our systems or attempt to decipher any transmissions to or from the servers running any part of the App;</li>
							<li>change or delete any ownership notices from materials downloaded or printed from the App;</li>
							<li>circumvent or modify any App security technology or software, without Java House’s express written consent.</li>
						</ul>
					</li>
					<h3>Charges for Use of the App</h3>
					<li>The use of the App is free save for your carrier´s normal rates. The App contains services and features that are available to certain mobile Devices.</li>
					<li>By using the App, you agree that we may communicate with you by electronic means to your mobile Device and that certain information about your use of these services may be shared with us. If you change or deactivate your mobile phone number, you have to immediately update your account information to ensure that we do not send your messages to the person who may have acquired your old number.</li>
					<h3>Data Protection and Privacy Policy</h3>
					<li>Personal details and other information relating to you provided to Java House through this App will only be used in accordance with our Privacy Policy. Please read this carefully before continuing. By downloading the App you are consenting to use of this information in accordance with our Privacy Policy, which is incorporated into these Terms and Conditions of Use by this reference and available at <a href="https://javahouseafrica.com/privacy-policy/" target="_blank">https://javahouseafrica.com/privacy-policy/</a></li>
					<h3>User Information and User Generated Content</h3>
					<li>Do not provide any false personal information about yourself. You confirm not to create more than one account, create an account on behalf of another individual, group or entity, or transfer your profile or account. Do not use or try to use another person's account, username or password.</li>
					<li>Java House reserves the right to monitor any information transmitted or received through any forum provided, and, at its sole discretion and without prior notice, to review, remove or otherwise block any material posted.</li>
					<li>Java House has no obligation to prescreen, monitor, edit or remove User Generated Content and assumes no responsibility for User Generated Content, even where it chooses to carry out prescreening, monitoring, editing or removal of User Generated Content.</li>
					<h3>Indemnification</h3>
					<li>You agree to indemnify, defend and hold harmless Java House, its affiliates, officers, directors, employees, agents, licensors and suppliers from and against all claims, losses, liabilities, expenses, damages and costs, including, without limitation, legal costs arising from or relating in any way to your User Generated Content, your use of Content, your use of the App or any violation of these Terms and Conditions of Use, any law or the rights of any third party.</li>
					<h3>Security</h3>
					<li>Shall you choose or are provided with a username, password or any other piece of information as part of Java House’s security procedures, you must treat such information as confidential and you must not disclose it to any third party nor allow any unauthorized person access to the App under your username and/or password.</li>
					<li>You are responsible for any actions that take place while using your App account or while using the App via your Device and Java House is not responsible for any loss that results from the unauthorized use of your username and/or password, with or without your knowledge.</li>
					<h3>Intellectual Property Rights (“IPR”)</h3>
					<li>All intellectual property contained in or on the App (except for User Generated Content) is owned by Java House. All content in the App (except for User Generated Content) including, but not limited to, text, software, scripts, code, designs, graphics, photos, sounds, music, videos, interactive features and all other content (“Content”) is a collective work under applicable copyright laws and is the proprietary property of Java House. Java House reserves all of its rights in respect of the IPR contained in the App and in respect of the Content.</li>
					<li>In particular, this App contains trademarks including, but not limited to, marks and word devices. Trademarks including, but not limited to, the Java House marks and word devices are owned by Java House. Java House reserves all of its rights in respect of the trademarks included on this App.</li>
					<li>Nothing in these Terms and Conditions of Use shall be interpreted as granting to you any license of IPR owned by Java House.</li>
					<h3>Disclaimer and Liability</h3>
					<li>You are responsible for the accuracy of the information that you enter or submit into the App. While Java House does its best to ensure that any information provided as part of this App is correct at the time of inclusion on the App, Java House cannot guarantee the accuracy of such information.</li>
					<li>To the fullest extent permitted by law, Java House disclaims all warranties, express or implied, regarding the operation and use of the App and any products accessed via the App. You understand and agree that you use the App at your own risk and that you are solely responsible for your use and for any damage to the Device through which you access the App, loss of data or any other harm of any kind which may result from downloading, accessing or using the App.</li>
					<li>To the fullest extent permitted by law, Java House shall under no circumstances whatsoever be liable to you, whether in contract, tort (including negligence), breach of statutory duty or otherwise, arising under or in connection with any products accessed via the App, your use of this App, or for your reliance on any information or advice contained in the App.</li>
					<li>Further, Java House shall not be liable to you or any third party in respect of, fraud, negligence, act, default or omission or willful misconduct of:
						<ul class="trems">
							<li>independent contractors engaged by Java House, or their employees, contractors or agents;</li>
							<li>and any retail site staff or their employees, contractors or agents</li>
						</ul>
					</li>
					<h3>Changes to/operation of the App</h3>
					<li>Java House may change the format and content of all or any part of this App at any time, including but not limited to removal of features or functionalities in the App.</li>
					<li>Java House may suspend or altogether discontinue the operation of this App, or of certain of its features or functionalities, including for support or maintenance work, in order to update the content or for any other reason.</li>
					<li>Updates to the App may be issued from time to time through the Appstore or Google Play. Depending on the update, you may not be able to use all or part of the App until you have downloaded the latest version of the App and accepted any new terms.</li>
					<h3>Transfer of Rights</h3>
					<li>Java House may transfer its rights and obligations under these Terms and Conditions of Use to any affiliate of Java House. Any such transfer will not affect your rights or Java House’s obligations under these Terms and Conditions of Use.</li>
					<h3>Severance</h3>
					<li>Each of the Clauses of these Terms and Conditions of Use operates separately. If any court or relevant authority decides that any of them are unlawful or unenforceable, the remaining Clauses or sub-clauses will remain in full force and effect.</li>
					<h3>Termination</h3>
					<li>Java House reserves the right in its sole discretion to terminate your account and/or access to this App or any functionalities thereof, delete your profile and any of your User Generated Content and/or restrict your use of all or any part of the App at any time, for any or no reason, without notice and without liability to you or anyone else. Java House also reserves the right to prevent access to the App or any of its functionalities or features.</li>
					<li>After any line of action subject to Clause 35 you are not allowed to create a new account to circumvent the termination, deletion or restriction.</li>
					<li>You understand and agree that some of your User Generated Content may continue to appear on or through the App or may persist in backup copies for a reasonable period of time even after your account and/or access to the App is terminated.</li>
					<li>These Terms and Conditions of Use remain in effect after your account and/or access to the App is terminated.</li>
					<h3>Changes to these Terms and Conditions of Use</h3>
					<li>Java House may change these Terms and Conditions of Use at any time without notice, effective upon posting the amended Terms and Conditions of Use to the App. In the event that the Terms and Conditions of Use are amended, you will be asked to accept those revised Terms and Conditions of Use when you next use the App. Any use of the App thereafter will be on the basis of those revised Terms and Conditions of Use.</li>
					<h3>Jurisdiction</h3>
					<li>These Terms and Conditions of Use are governed by and to be interpreted in accordance with the laws of Kenya and in the event of any dispute arising in relation to these terms and conditions or any dispute arising in relation to the App the courts of Kenya will have non-exclusive jurisdiction over such dispute</li>
				
				</ul>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>		