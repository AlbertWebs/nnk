<h2>New Membership Application</h2>
<p><strong>Name:</strong> {{ $form['quote-request-name'] }}</p>
<p><strong>Email:</strong> {{ $form['quote-request-email'] }}</p>
<p><strong>Phone:</strong> {{ $form['quote-request-phone'] }}</p>
<p><strong>Company:</strong> {{ $form['quote-request-company'] ?? 'N/A' }}</p>
<p><strong>Interests:</strong> {{ implode(', ', $form['quote-request-interest'] ?? []) }}</p>
<p><strong>Message:</strong><br>{{ $form['quote-request-message'] }}</p>
