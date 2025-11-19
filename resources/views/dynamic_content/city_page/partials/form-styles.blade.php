<style>
    .city-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        margin-bottom: 1.5rem;
    }

    .city-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .city-selected-pill {
        border: 1px dashed #cbd5f5;
        border-radius: 0.75rem;
        padding: 0.9rem 1.1rem;
        background: #f8fafc;
        min-height: 56px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
        color: #0f172a;
    }

    .city-search-container {
        position: relative;
    }

    .city-search-results {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.15);
        max-height: 260px;
        overflow-y: auto;
        z-index: 50;
    }

    .city-search-results.d-none {
        display: none;
    }

    .city-search-results button {
        background: transparent;
        border: 0;
        width: 100%;
        text-align: left;
        padding: 0.8rem 1rem;
        font-weight: 500;
        color: #0f172a;
        transition: background 0.2s ease;
    }

    .city-search-results button:hover {
        background: #f1f5f9;
    }

    .city-image-preview {
        border: 1px dashed #cbd5f5;
        border-radius: 0.75rem;
        background: #f8fafc;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
    }

    .city-image-preview img {
        max-height: 140px;
        object-fit: cover;
    }

    @media (max-width: 576px) {
        .city-card {
            padding: 1rem;
        }

        .city-selected-pill {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>


