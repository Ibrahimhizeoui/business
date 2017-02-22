jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
                var frm = $('form');
                frm.submit(function(e){
                	
                	$.ajax({
                		type: 'POST',
                		url:  Routing.generate('ajouter_fournisseur', /* your params */),
                		data: frm.serialize(),
                		beforeSend: function(){
                			console.log('charge');
                			$('.bb').css( "display", "initial" );
                		},
                		success: function(data){
                			$('.bb').css( "display", "none" );
                			
                			$(form).trigger("reset");

                		}

                	});
                	e.preventDefault();
                });
               
            });