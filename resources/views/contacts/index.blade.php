@extends('app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('contacts.create') }}" class="btn btn-primary mb-3">Create New Contact</a>

    <form action="{{ route('contacts.search') }}" method="GET" class="mb-3">
        <div class="form-group">
            <label for="email">Search by Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->address }}</td>
                <td>
                    <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-primary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-contact" data-contact-id="{{ $contact->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Delete contact
            $('.delete-contact').click(function() {
                var contactId = $(this).data('contact-id');
                var deleteUrl = "{{ route('contacts.destroy', ':id') }}".replace(':id', contactId);

                if (confirm('Are you sure you want to delete this contact?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection
