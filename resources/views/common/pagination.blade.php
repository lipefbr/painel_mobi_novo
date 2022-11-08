 <hr>
    
 <div class="row">
 	<div class="col-sm-6 page_info">
        Exibindo {{($pagination->currentPage-1)*$pagination->perPage+1}} a {{$pagination->currentPage*$pagination->perPage}}
        de  {{$pagination->total}}                    
    </div>
    <div class="col-sm-6 pagination justify-content-end">
        {{ $pagination->links}}
    </div>
</div>