<h2>Clients</h2>

<script id="itp-itemTmpl" type="text/x-jquery-tmpl">

  <div id="${Item.id}" class="itp-item ${Item.statusClass} span-17">

    <div class="itp-itemHead">

      <div class="textItem">
        <span class="itp-itemType ${Item.typeClass}">${Item.typeText}</span>
        <span class="itemCrated">${Item.created}</span>
        <span id="dp-${Item.id}" class="itp-targetItem">${Item.target}</span>

        {{each Tag}}
          <span data-ittaggedid="${Tagged.id}" class="itp-itemTag">${name}</span>
	{{/each}}

        <span class="itemHead">${Item.item}</span>
      </div>
      <div class="statusItem">${Item.statusText}</div>
    </div>
  </div>

</script>