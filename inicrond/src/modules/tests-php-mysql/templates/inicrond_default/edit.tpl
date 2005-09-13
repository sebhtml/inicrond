{* Smarty *}

<form method="POST">


	<table cellspacing="5" cellpadding="5"   >
	{section name=row loop=$test_parameters}
		<tr>
		{section name=cell loop=$test_parameters[row]}
			<td class="top_menu">{$test_parameters[row][cell]}</td>
		{/section}
		</tr>
	{/section}
	</table>

<input type="submit" name="envoi" />
</form>

<form method="POST">
	
	

	{section name=row loop=$add_qs}

		{section name=cell loop=$add_qs[row]}
			{$add_qs[row][cell]}
		{/section}

	{/section}

</form>	
<br /><br />
	

	

	{section name=row loop=$questions}
		

		
 
			{$questions[row].q_number}
		{$questions[row].question_CODE}

		{$questions[row].remove}

			{$questions[row].get_it_up}

			{$questions[row].get_it_down}

			{$questions[row].edit_a_question}
			

			{$_LANG.pts_amount_for_good_answer} :
			{$questions[row].good_points}

			{$_LANG.pts_amount_for_bad_answer} :
			{$questions[row].bad_points}

			<br />
			
		
			[{$questions[row].q_type_str}]<br />
			
				

					
			{$questions[row].question_area}
					<br /><br />
	{/section}

	
	

