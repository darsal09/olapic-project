/**
 * Created by darsa on 3/5/2017.
 */

var customers = {
    init:function(){
//            this.loadCustomers();
        this.events();
    },
    events:function(){
        $( 'ul#media_links li').on( 'click', this.loadCustomerImages );
        $( 'DIV#images').on('click', 'button.addImages', this.sendImage);
    },
    sendImage:function(){
        var id= $(this).attr( 'image-id');
        var caption = $( this).attr( 'image-caption' );
        var url = $( this).attr( 'image-url');

        var sdk = new OlapicPartnerSdk();
        if(sdk.sendMedia({
                url: url,
                caption: caption
            })){
            $(this).attr("disabled","disabled");
        }
    },
    loadCustomerImages:function(){
        var id =  $( '#customer_id').html( );
        var media_type = $( this).attr( 'media-type' );
        var url = '/customers/'+id+'/'+media_type;
        var $divImages = $( 'div#images' );
        $divImages.html( '<i class="fa fa-spinner fa-spin" style="font-size:36px;color:red"></i>' );
        $( '#images_header').html( 'Loading '+ media_type+' media images:' );
        $.ajax({
            url:url,
            method:'GET',
            dataType:'json'
        }).done(function( data){
            $( '#images_header' ).html( 'Displaying '+media_type+' media images' );
            $divImages.html( '' );
            for( x in data ){
                var image = data[ x];
                if( x%4 == 0 ){
                    $divContainer = $( '<div class="w3-row"></div>');
                }
                $divContainer.append( $( '<div class="w3-quarter"></div>').append( '<div class="w3-card-2" style="margin: 3px;"><image class="w3-image" width="100%" src="'+image.images.thumbnail+'"><div class="w3-container"><button class="addImages" image-id="'+image.id+'" data-caption="'+image.caption+'" image-url="'+image.images.normal+'">Add To Partner App</button></div></div>'));
                if( x%4 == 3){
                    $divImages.append( $divContainer );
                }
            }
        }).fail( function(){
           $divImages.html( '<h1>There was an error loading the images' );
        });
    },
    loadCustomer:function(){
        var id = $( '#customer_id').text();
        var media_type = $( this).attr( 'media-type' );
        $.ajax({
            url:'/customers/'+id+'/'+media_type,
            method:'GET',
            dataType: 'json'
        }).done( function(  data ){
            var media = data.media;
            for( x in media ){
                $( 'ul#customers').append($( '<li>' ).text( customers[x].name).attr( 'data-id', customers[ x].id) );
            }
        } ).fail();
    }
};

$(function(){
    customers.init();
});

