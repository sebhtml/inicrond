{* Smarty *}
<p align="center">
<form method="POST">
<h1>BETA, based on inicrond 3.2.0</h1>
{* test conf *}
<fieldset>
		<legend>{$_LANG.test_configuration}</legend>
	<table cellspacing="5" cellpadding="5"   >
	{section name=row loop=$test_parameters}
		<tr>
		{section name=cell loop=$test_parameters[row]}
			<td class="top_menu">{$test_parameters[row][cell]}</td>
		{/section}
		</tr>
	{/section}
	</table>
	</fieldset>
		
		{* add a question *}
	
	<fieldset>
		<legend>{$_LANG.question_adding}</legend>
	<table cellspacing="5" cellpadding="5"   >
	{section name=row loop=$add_qs}
		<tr>
		{section name=cell loop=$add_qs[row]}
			<td class="top_menu">{$add_qs[row][cell]}</td>
		{/section}
		</tr>
	{/section}
	</table>
	
	{* add a question from the bank *}
	
	</fieldset>

	
<table cellspacing="5" cellpadding="5"   >
	{section name=row loop=$questions}
		<tr>
		
			<td class="inode_element" valign="top">
			{$questions[row].q_number}
			
			<br />
			<b>{$_LANG.question_CODE} :
			{$questions[row].question_CODE}</b>
			
			<br />
			{$_LANG.pts_amount_for_good_answer} :
			{$questions[row].good_points}
			<br />
			{$_LANG.pts_amount_for_bad_answer} :
			{$questions[row].bad_points}
			<br />
			{$questions[row].remove}
			<br />
			{$questions[row].get_it_up}
			<br />
			{$questions[row].get_it_down}
			
			</td>
			<td class="inode_element">
			{$questions[row].q_type_str}
				<table cellspacing="5" cellpadding="5"   ><tr>
					<td class="top_menu">
			{$questions[row].question_name}
					</td>
					<td class="top_menu">
			{$questions[row].question_area}
					</td></tr>
				</table>
			{if $questions[row].q_type==0}
		<table cellspacing="5" cellpadding="5"   >
		<tr>
					<td class="inode_elements">
			{$questions[row].a_rand_flag_str}
					</td>
					<td class="top_menu">
			{$questions[row].a_rand_flag_form_o}
					</td></tr>
						<tr>
					<td class="top_menu">
			{$correcting_method_str}
					</td>
					<td class="top_menu">
			{$questions[row].correcting_method_form_o}
					</td></tr>
					
					
					
		</table>	
			{$questions[row].add_answer}
			<table cellspacing="5" cellpadding="5"   >
			{section name=an_answer loop=$questions[row].answers}
		<tr>
		<td class="top_menu">
		{$questions[row].answers[an_answer].id}
		</td>
		<td class="top_menu">
		{$questions[row].answers[an_answer].form_o}
		</td>
		<td class="top_menu">
		{$questions[row].answers[an_answer].is_good_flag}
		<br />
		{$questions[row].answers[an_answer].remove}
		<br />
		{$questions[row].answers[an_answer].get_it_up}
		<br />
		{$questions[row].answers[an_answer].get_it_down}
		<br />
		{$pts_amount_for_good_answer} :
		{$questions[row].answers[an_answer].pts_amount_for_good_answer_form_o}
		<br />
		{$pts_amount_for_bad_answer} :
		{$questions[row].answers[an_answer].pts_amount_for_bad_answer_form_o}
		

		</td>
		
		</tr>
			{/section}
			</table>
			{/if}
			{if $questions[row].q_type == 1}
			<table cellspacing="5" cellpadding="5"   >
			<tr>
					<td class="top_menu">
			{$questions[row].answer_str}
					</td>
					<td class="top_menu">
			{$questions[row].answer_form_o}
					</td>
					</tr>
				</table>
			{/if}
			{if $questions[row].q_type==2}
			{$questions[row].swf_form_o}
			{/if}
			
			{if $questions[row].q_type==3}
			<table cellspacing="5" cellpadding="5"   >
				<tr>
					<td class="top_menu">
			{$correcting_method_str}
					</td>
					<td class="top_menu">
			{$questions[row].correcting_method_form_o}
					</td>
				</tr>
				</table>
				
				{* short answers *}
				{$questions[row].add_answer}
			<table cellspacing="5" cellpadding="5"   >
			{section name=an_answer loop=$questions[row].answers}
		<tr>
		
		<td class="top_menu">
		{$questions[row].answers[an_answer].form_o}
		</td>
		<td>
		
		{$questions[row].answers[an_answer].remove}
		
		<br />
		{$pts_amount_for_good_answer} :
		{$questions[row].answers[an_answer].pts_amount_for_good_answer_form_o}
		<br />
		{$pts_amount_for_bad_answer} :
		{$questions[row].answers[an_answer].pts_amount_for_bad_answer_form_o}
		

		</td>
		
		</tr>
			{/section}
			</table>	
			{/if}
			</td>
		</tr>
	{/section}
	</table>
	
	
	{$validate}
</form>
</p>
