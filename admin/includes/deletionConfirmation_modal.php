<div>
	<div class="modal fade" id="deletion-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deletion-modal-label">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="deletion-modal-label">Supprimer la sélection ?</h4>
	      		</div>
      			<div class="modal-body">
	    			<p>Souhaitez-vous vraiment supprimer votre sélection ?</p>
	    			<p>Cette action est irréversible et les données seront perdues !</p>
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
	        		<button type="button" class="btn btn-danger" data_dismiss="modal" onclick="deleteSelection('<?= $keyword ?>');">Supprimer</a>
	      		</div>
	    	</div>
	  	</div>
	</div>
</div>