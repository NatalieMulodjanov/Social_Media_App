<html>

<head>
	<title>Profile</title>
</head>

<?php
$user = new \app\models\User();
$user = $user->get($_SESSION['username']);
if (!isset($user->two_factor_authentication_token)) {
	echo "<a href=" . BASE . "User/setup2fa>Set up Two Factor Authentication</a>";
}
?>

<body>
	<a href="<?= BASE ?>Profile/update">Update Profile</a>
	<a href="<?= BASE ?>Picture/index/<?= $data['profile']->profile_id ?>">Post a picture</a>
	<a href="<?= BASE ?>Message/create/<?=$data['profile']->profile_id?>">Create Message</a>
	<a href="<?= BASE ?>Message/sent/<?=$data['profile']->profile_id?>">Sent Messages</a>
	<a href="<?= BASE ?>User/logout">Logout</a>

	<h3>Search</h3>
		<form action='/profile/searchByName' method='post'>
			Name: <input type='text' name='username' value='' />
			<input type='submit' name='action' value='searchByName' />
		</form>

	<h2>Profile Name</h2>
	<?php
	$profile = $data['profile'];
	echo "<h3>$profile->first_name $profile->middle_name $profile->last_name</h3>";
	?>

	<table>
		<tr>
			<th>From</th>
			<th>Message</th>
			<th>Timestamp</th>
			<th>Read Status</th>
			<th>Private Status</th>
			<th>Actions</th>
		</tr>
		<?php
		foreach ($data['messages'] as $message) {
			$convertedTimeStamp = \app\core\helpers\Helper::ConvertDateTime($message->timestamp);
			$senderProfile = new \app\models\Profile();
			$senderProfile = $senderProfile->get($message->sender);

			echo "<tr>
			<td>$senderProfile->first_name $senderProfile->last_name</td>
			<td>$message->message</td>
			<td>$convertedTimeStamp</td>
			<td>$message->read_status</td>
			<td>$message->private_status</td>
			<td>
				<a href='".BASE."Message/read/$message->message_id'>read</a>
				<a href='".BASE."Message/to_reread/$message->message_id'>to reread</a>
				<a href='".BASE."Message/delete/$message->message_id'>delete</a>
			</td>
		</tr>";
		}
		?>
	</table>
	
	<h2>Pictures</h2>
	<table>
		<tr>
			<th>Picture</th>
			<th>Caption</th>
			<th>Like Amount</th>
			<th>Actions</th>
		</tr>
		<?php
		foreach ($data['pictures'] as $picture) {
			$likeAmount = $picture->getLikeAmount($picture->picture_id);
			if($likeAmount == 0){
				$likeAmount = 0;
			}
			echo "<tr>
			<td><img src='".BASE."uploads/$picture->file_name' width=300 height=250 caption='$picture->caption'/></td>
			<td>$picture->caption</td>
			<td>$likeAmount</td>
			<td>
				<a href='".BASE."Picture_like/like/$picture->picture_id'>like</a>
				<a href='".BASE."Picture_like/unlike/$picture->picture_id'>unlike</a>
			</td>
		</tr>";
		}
		?>
	</table>
</body>
</html>
