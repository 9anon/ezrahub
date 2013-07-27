## Honeypot - Form Defender

Honeypot is a Laravel framework bundle that uses the honeypot techinque to defend web forms. We put a fake form field in the form (hidden) with a common name which spam bots think is real. They fill it out and we check to see if it's filled in. If it is, we know a bot filled out the form.

We also include a second defence mechanism using a timestamp. If the form takes less that 5 seconds to fill in (you can configure the speed) we'll figure it's spam.

## Installation

In your applications bundles.php put:

	return array(
		'honeypot' => array('auto' => true),
	);

Add the Honeypot fields to your form

	{{ Form::open('save') }}

		{{ Form::honeypot('honey_field_name', 'time_field_name') }}
		....
	{{ Form::close() }}

Then use Honeypot's custom form validators to check your form date. Note the honeytime takes a number for the minimum seconds it should take to fill out the form for a human. If it takes less time than that we fail the test. For example:

	$rules = array(
		'email' 			=> "required|email",
		'field_name' 		=> 'honeypot',
		'field_name_time'	=> 'required|honeytime:5'
	);

	$validator = Validator::make(Input::get(), $rules);