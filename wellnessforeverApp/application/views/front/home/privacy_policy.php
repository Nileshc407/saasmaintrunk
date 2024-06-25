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
				<div><h1>Privacy Policy</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 termsPrivacyWrapper">
				<p>Nairobi Java House Limited (“Java House” “us”, “we”, or “our”) operates <a href="https://javahouseafrica.com" target="_blank">https://javahouseafrica.com</a> (the “Site”). This page informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site.</p>
				<p>Your privacy is important to us and we are committed to protecting your personal data. By using the Site, you agree to the collection and use of information in accordance with this privacy policy.</p>
				<h3>Information Collection and Use</h3>
				<p>While using our Site, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information could be collected from profile data, usage data, financial data, transactional data, technical data and marketing/communication data. The type of personal data we collect depends on how you interact with us.</p>
				<p>Kindly note that if you choose not to share certain personal data with us, we might not be able to provide the products, services or information you have may require from the website.</p>
				<h3>How we Collect Data</h3>
				<p>We collect and receive data in different ways. You may give us data in person when you: visit our website; visit our restaurants and pay via mobile money; interact with us on social media; interact with our staff and other guests; make enquiries or request information; book to reserve table space; or register for our Loyalty Application and/or Programme & Gift Cards.</p>
				<p>We may get some data automatically when you interact with us, via this site. This may include information such as your computer’s Internet Protocol (“IP”) address, browser type, browser version, and the pages of our Site that you visit, the time and date of your visit, the time spent on those pages and other statistics. The data could be from technology partners who help us run our mailing list sign-ups, from providers of payment, from analytics providers, or from feedback partners.</p>
				<h3>Information Regarding Children and Persons Lacking Legal Capacity</h3>
				<p>The content of the Site is not targeted towards, nor intended for use by anyone under the age of thirteen (13) years. A user must be at least this age to access and use this website. If a user is between the ages of thirteen (13) years and age eighteen (18), he or she may only use this website under the supervision of a parent or legal guardian who agrees to be bound by these Terms. We do not at any time knowingly/intentionally collect information regarding children and other persons lacking legal capacity.</p>
				<h3>How we Use the Information Collected</h3>
				<p>We may use your Personal Information to contact you with marketing or promotional materials and other information when we have consent from you to receive direct marketing materials from us. You can decide to opt out of these marketing or promotional materials.</p>
				<p>We will use your personal information primarily to request your evaluation of your experience with us and to respond to your customer-service enquiries or requests.</p>
				<p>We may share your personal data with third parties for the purposes set out in this Privacy Policy and only to the extent permitted by law. The third parties could include: other restaurants in our group; auditors and professional advisers like lawyers and accountants; government, regulators and law enforcement.</p>
				<p>We may also share aggregated demographic and statistical information in the course of our business with certain third parties. This sharing does not include any personal information that can identify any individual person.</p>
				<h3>Cookies</h3>
				<p>Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer’s hard drive. Like many sites, we use “cookies” to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.</p>
				<h3>Security</h3>
				<p>The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.</p>
				<p>We intend to keep your personal data safe and we have put in place appropriate security measures to ensure its confidentiality, integrity and availability. We also make sure that only authorised people are able to access your data, including employees, agents and other third parties. They will only process your personal data on our instructions and they are subject to a duty of confidentiality.</p>
				<p>We have put in place procedures to deal with any suspected personal data breach and will notify you and any applicable regulator of a breach where we are legally required to do so.</p>
				<p>We will only keep your personal data for as long as we need to fulfil the purposes we collected it for. In some circumstances we may remove your identity from your personal data for statistical purposes, in which case we may use this information indefinitely without further notice to you.</p>
				<h3>Attendant User Rights</h3>
				<p>You have the right under specific circumstances to object to processing of your personal data; request restriction of processing your personal data; or withdraw consent.</p>
				<h3>Changes to This Privacy Policy</h3>
				<p>This Privacy Policy is effective as of (add date) and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.</p>
				<p>We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Service after we post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.</p>
				<h3>Contact Us</h3>
				<p>If you have any questions about this Privacy Policy, please contact us.</p>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>		