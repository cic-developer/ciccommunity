<!-- 이메일 인증시 이용되는 폼 -->
<table width="600" border="0" cellpadding="0" cellspacing="0" style="border-left: 1px solid rgb(226,226,225);border-right: 1px solid rgb(226,226,225);background-color: rgb(255,255,255);border-top:10px solid #348fe2; border-bottom:5px solid #348fe2;border-collapse: collapse;">
	<tr>
		<td width="101" style="padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;"><?php echo html_escape(element('site_title', $emailform)); ?></td>
		<td width="497" style="font-size:12px;padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;"><span style="font-size:14px;font-weight:bold;color:rgb(0,0,0)">안녕하세요 <?php echo html_escape(element('name', $emailform)); ?>님,</span><br />이것은 [CIC] 비밀번호 찾기를 통해 발송된 이메일입니다
		</td>
	</tr>
	<tr style="border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2;">
		<td colspan="2" style="padding:20px 30px;font-family: Arial,sans-serif;color: rgb(0,0,0);font-size: 14px;line-height: 20px;">
		<p>안녕하세요,</p>
		<p>회원님의 임시 비밀번호가 발급되었습니다.</p>
		<br>
		<br>
		<h1>임시 비밀번호: <strong><?php echo html_escape(element('imPw', $emailform)); ?></strong></h1>
		<br>
		<br>
		<p>감사합니다.</p>
		</td>
	</tr>
</table>

