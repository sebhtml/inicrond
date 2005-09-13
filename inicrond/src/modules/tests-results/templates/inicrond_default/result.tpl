{* Smarty *}


<br />
{$_LANG.usr_id} : {$usr_id}<br />
{$_LANG.usr_name} : {$usr_link}<br />
{$_LANG.test_name} : {$test_name}<br />
{$_LANG.test_id} : {$test_id}<br />
{$_LANG.result_id} : {$result_id}<br />
{$_LANG.date} : {$date}<br />
{$_LANG.elapsed_time} : {$length}<br />
{$_LANG.points} : {$score}<br />
<br />
<table >
{section name=question loop=$questions_list}

<tr>	
	
	<td>
	#{$questions_list[question].q_num}
	
	{if $questions_list[question].q_type == 0}
	<br /><i>{$_LANG.multiple_choices_question}</i>
	
		<br /><u>{$_LANG.correcting_method_str} : 
	
		{if $questions_list[question].correcting_method == 0}
		{$_LANG.correcting_method_0} 
		{/if}
	
		{if $questions_list[question].correcting_method == 1}
		{$_LANG.correcting_method_1} 
		{/if}</u>
		
	{/if}
	
	{if $questions_list[question].q_type == 3}
	<br /><i>{$_LANG.multiple_short_answers_q}</i>
	
		<br /><u>{$_LANG.correcting_method_str} : 
	
		{if $questions_list[question].correcting_method == 0}
		{$_LANG.correcting_method_0} 
		{/if}
	
		{if $questions_list[question].correcting_method == 1}
		{$_LANG.correcting_method_1} 
		{/if}</u>
		
	{/if}
	
	{if $questions_list[question].q_type == 1}
	<br /><i>{$_LANG.single_answer_question}</i>
	{/if}
	{if $questions_list[question].q_type == 2}
	<br /><i>{$_LANG.flash_based_question}</i>
	{/if}
	
	

	{* points attribution *}
	<br /><b>
	{$questions_list[question].your_points}
	{$_LANG.points}
	/
	{$questions_list[question].points}
	{$_LANG.points}
	</b>
	<br /><br />

	
	
	
	{$questions_list[question].question_name}
	
	<br />

	{* multiple answer question *}
	{if $questions_list[question].q_type == 0}
		
	<table>
	
	
	{section name=answer loop=$questions_list[question].answers}
	<tr>
	<td>
	<span style="color: {$questions_list[question].answers[answer].correction_color};">
	{$questions_list[question].answers[answer].a_num}
	</span></td>
	<td>{$questions_list[question].answers[answer].form_o}</td>
	<td>{$questions_list[question].answers[answer].answer_name}</td>
	
	{if $questions_list[question].correcting_method == 1}
	
		{if $questions_list[question].answers[answer].is_good}
	<td>
	<span style="color: green;">
	<b><u>{$questions_list[question].answers[answer].pts_amount_for_good_answer} </u></b>
	</span>
	</td>
	
	<td>
	<span style="color: red;">
	{$questions_list[question].answers[answer].pts_amount_for_bad_answer}  
	</span>
	</td>
		{/if}
		
		{if $questions_list[question].answers[answer].is_good == 0}
		<td>
		<span style="color: green;">
		{$questions_list[question].answers[answer].pts_amount_for_good_answer} 
		</span>
		</td>
		
		<td>
		<span style="color: red;">
		<b><u>{$questions_list[question].answers[answer].pts_amount_for_bad_answer}  </u></b>
		</span>
		</td>
		{/if}
	{/if}
	</tr>
	
	
	{/section}
	</table>

	
	
	{/if}
	
	{if $questions_list[question].q_type == 1}
	
	{$_LANG.your_answer} : 
	
		<span style="color: {$questions_list[question].correcting_color};">
			{$questions_list[question].given_answer}
			</span>
			<br />
	
	{* show the real answer *}
					
	{if $questions_list[question].short_answer != ""}
	{$_LANG.the_good_answer} : {$questions_list[question].short_answer}<br />
	
	{/if}
	
	{/if}
	
	{if $questions_list[question].q_type == 2}
	
		{$questions_list[question].flash}
	<br /><br />
		{if $questions_list[question].done}
		{$questions_list[question].points_obtenu}/{$questions_list[question].points_max}={$questions_list[question].percent}<br />
		{$questions_list[question].delta_time}
		{else}
		{$questions_list[question].points_obtenu}/{$questions_list[question].points_max}={$questions_list[question].percent}<br />
		{$questions_list[question].delta_time}<br />
		{$_LANG.undone}
		
		{/if}
		


	
	{/if}
	
	{* multiple short answer *}
	
	{if $questions_list[question].q_type == 3}
	
	{$_LANG.your_answer} : 
	
		
			{$questions_list[question].given_answer}
			<br />
	
	{* list the preg_answers list *}
	<table>
	
	{section name=answer loop=$questions_list[question].answers}
	<tr>
	
	<td><span style="color: {$questions_list[question].answers[answer].correction_color};">
	
	{$questions_list[question].answers[answer].answer_name}
	</span>
	</td>
	
	
	{if $questions_list[question].correcting_method == 1}
		{if $questions_list[question].answers[answer].is_good}
	<td>
	<span style="color: green;">
	<b><u>{$questions_list[question].answers[answer].pts_amount_for_good_answer} </u></b>
	</span>
	</td>
	
	<td>
	<span style="color: red;">
	{$questions_list[question].answers[answer].pts_amount_for_bad_answer} 
	</span>
	</td>
		{/if}
		
	
		{if $questions_list[question].answers[answer].is_good == 0}
		<td>
		<span style="color: green;">
		{$questions_list[question].answers[answer].pts_amount_for_good_answer} 
		</span>
		</td>
		
		<td>
		<span style="color: red;">
		<b><u>{$questions_list[question].answers[answer].pts_amount_for_bad_answer}  </u></b>
		</span>
		</td>
		{/if}
	
	
	{/if}
	</tr>
	
	
	{/section}
	</table>
	
	
	
	{/if}
	<hr />
	</td>

</tr>

{/section}
</table>

