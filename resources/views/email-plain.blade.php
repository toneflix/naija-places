Hi {{ $name ?? 'there' }},
@foreach ($lines as $line)
    {!! is_array($line) ? $line['link'] ?? '' : strip_tags($line ?? '') !!}
@endforeach
