<div class="card">
    <h5>{{ $book->title }}</h5>
    <p>{{ $book->author }}</p>
    <p>Status: {{ $book->is_available ? 'Available' : 'Borrowed' }}</p>
    @if ($book->borrowers->isNotEmpty())
        <p class="card-text">Borrowers:</p>
        <ul>
            @foreach ($book->borrowers as $borrower)
                <li>{{ $borrower->borrowable->name }} ({{ $borrower->created_at->format('d M, Y') }})</li>
            @endforeach
        </ul>
    @else
        <p class="card-text">No borrowers yet.</p>
    @endif
</div>
<style>
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        max-width: 300px;
        margin: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .card h5 {
        font-size: 1.25rem;
        color: #333;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 1rem;
        color: #666;
        margin: 5px 0;
    }

    .card p:first-child {
        font-weight: bold;
    }

    .card p:last-child {
        font-size: 0.9rem;
        color: #28a745;
        /* Green color for available status */
    }

    .card p:last-child.borrowed {
        color: #dc3545;
        /* Red color for borrowed status */
    }
</style>
