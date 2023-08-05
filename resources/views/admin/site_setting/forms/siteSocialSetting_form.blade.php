{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'facebook_address') !!}">
        {!! Form::label('facebook_address', 'Facebook Address', ['class' => 'bold']) !!}                    
        {!! Form::text('facebook_address', null, array('class'=>'form-control', 'id'=>'facebook_address', 'placeholder'=>'Facebook Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'facebook_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'twitter_address') !!}">
        {!! Form::label('twitter_address', 'Twitter Address', ['class' => 'bold']) !!}                    
        {!! Form::text('twitter_address', null, array('class'=>'form-control', 'id'=>'twitter_address', 'placeholder'=>'Twitter Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'twitter_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'instagram_address') !!}">
        {!! Form::label('instagram_address', 'Instagram Address', ['class' => 'bold']) !!}                    
        {!! Form::text('instagram_address', null, array('class'=>'form-control', 'id'=>'instagram_address', 'placeholder'=>'Instagram Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'instagram_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'linkedin_address') !!}">
        {!! Form::label('linkedin_address', 'Linkedin Address', ['class' => 'bold']) !!}                    
        {!! Form::text('linkedin_address', null, array('class'=>'form-control', 'id'=>'linkedin_address', 'placeholder'=>'Linkedin Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'linkedin_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'youtube_address') !!}">
        {!! Form::label('youtube_address', 'Youtube Address', ['class' => 'bold']) !!}                    
        {!! Form::text('youtube_address', null, array('class'=>'form-control', 'id'=>'youtube_address', 'placeholder'=>'Youtube Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'youtube_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'tumblr_address') !!}">
        {!! Form::label('tumblr_address', 'Tumblr Address', ['class' => 'bold']) !!}                    
        {!! Form::text('tumblr_address', null, array('class'=>'form-control', 'id'=>'tumblr_address', 'placeholder'=>'Tumblr Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'tumblr_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'flickr_address') !!}">
        {!! Form::label('flickr_address', 'Flickr Address', ['class' => 'bold']) !!}                    
        {!! Form::text('flickr_address', null, array('class'=>'form-control', 'id'=>'flickr_address', 'placeholder'=>'Flickr Address')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'flickr_address') !!}                                       
    </div>
</div>
