import { useState } from 'react';

export function useSearch(initialValue: string, url: string) {
    const [search, setSearch] = useState(initialValue);

    const onSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearch(e.target.value);
        // In a real implementation, you would typically debounce this
        // and then make a request to the server.
        console.log(`Searching for ${e.target.value} at ${url}`);
    };

    return { search, onSearch };
}
