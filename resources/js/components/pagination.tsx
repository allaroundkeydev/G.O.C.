import React from 'react';

export function Pagination({ paginated }: { paginated: any }) {
    return (
        <div className="pagination">
            {/* Placeholder for pagination controls */}
            <span>Page {paginated.current_page} of {paginated.last_page}</span>
        </div>
    );
}
