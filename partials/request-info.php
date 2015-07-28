<div class="blog-single-cta">
	<span class="h2">Request Information about a WorldStrides Program</span>
	<form>
		<span>I am a</span>
		<select id="selectMenu">
			<option value="/request-info/?type=parent">Parent</option>
			<option value="/request-info/?type=traveler">Traveler</option>
			<option value="/request-info/?type=teacher">Teacher</option>
		</select>
		<input type="submit" class="btn btn-primary" value="Get the Info" onclick="window.open(selectMenu.options[selectMenu.selectedIndex].value)">
	</form>
</div>