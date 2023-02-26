
<?php
include('config.php');
include('fungsi.php');

// header
include('header.php');
?>

	<section class="content">
			<h2 class="ui header">การแนะนำซัพพลายเออร์ที่เหมาะสม</h2>

			<p>ช่วยในตัดสินใจโดยการหาซัพพลายเออร์ที่เหมาะสมที่สุดโดยผ่านวิธี (AHP) Analytic Hierarchy Process</p>
			<p>วิธีการใช้งาน</p>
			<ol class="ui list">
			<li>เพิ่มบริษัทซัพลายเออร์</li>
				<li>ให้คะแนนการประเมินความสำคัญสำหรับการเปรียบเทียบในแต่ละบริษัทซัพพลายเออร์</li>
				<li>แสดงลำดับซัพพลายเออร์ที่เหมาะสมที่สุด</li>
			</ol>

			<br>

			<h3 class="ui header">ค่าคะแนนการประเมินความสำคัญ</h3>
			<table class="ui collapsing striped blue table">
				<thead>
					<tr>
					<th>ระดับความสำคัญ</th>
						<th>ความหมาย</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="center aligned">1</td>
						<td>ทั้งสองปัจจัยมีความสำคัญเท่ากัน</td>
					</tr>
					<tr>
						<td class="center aligned">2</td>
						<td>ค่ากลางระหว่าง1-3</td>
					</tr>
					<tr>
						<td class="center aligned">3</td>
						<td>ปัจจัยหนึ่งมีความสำคัญมากกว่าอีกปัจจัยหนึ่งเล็กน้อย</td>
					</tr>
					<tr>
						<td class="center aligned">4</td>
						<td>ค่ากลางระหว่าง3-5</td>
					</tr>
					<tr>
						<td class="center aligned">5</td>
						<td>ปัจจัยหนึ่งมีความสำคัญมากกว่าอีกปัจจัยหนึ่งปานกลาง</td>
					</tr>
					<tr>
						<td class="center aligned">6</td>
						<td>ค่ากลางระหว่าง5-7</td>
					</tr>
					<tr>
						<td class="center aligned">7</td>
						<td>ปัจจัยหนึ่งมีความสำคัญมากกว่าอีกปัจจัยหนึ่งค่อนข้างมาก</td>
					</tr>
					<tr>
						<td class="center aligned">8</td>
						<td>ค่ากลางระหว่าง7-9</td>
					</tr>
					<tr>
						<td class="center aligned">9</td>
						<td>ปัจจัยหนึ่งมีความสำคัญมากกว่าอีกปัจจัยหนึ่งมากที่สุด</td>
					</tr>
				</tbody>
			</table>

	</section>

<?php include('footer.php'); ?>
