{* Smarty *}


<form method="POST">

{$result_id}
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
	
	{* multiple short answer *}
	
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
	
	
	
	<br />
	<b>
	{$questions_list[question].points}
	{$_LANG.points}
	</b>
	<br /><br />

	
	{$questions_list[question].question_name}
	
	<br />


	{if $questions_list[question].q_type == 0}
		
	<table>
	
	
	{section name=answer loop=$questions_list[question].answers}
	<tr>
	<td>{$questions_list[question].answers[answer].a_num}</td>
	<td>{$questions_list[question].answers[answer].form_o}</td>
	<td>{$questions_list[question].answers[answer].answer_name}</td>
	
	
	</tr>
	
	
	{/section}
	
	</table>
	{/if}
	
	{if $questions_list[question].q_type == 1}
	
	{$questions_list[question].short_answer}
	
	{/if}
	
	{* short answer text area *}
	{if $questions_list[question].q_type == 3}
	
	{$questions_list[question].short_answer}
	
	{/if}
	
	{if $questions_list[question].q_type == 2}
	
	{$questions_list[question].flash}
	
	{/if}
	<hr />
	</td>

</tr>

{/section}
</table>
{$submit}

</form>