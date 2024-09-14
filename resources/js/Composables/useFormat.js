import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import dayjs from "dayjs";

export function useFormat() {

    const date = (date, format = 'MM/DD/YYYY') => {
        return dayjs(date).format(format)
    };

    const mimeTypeIcon = (mimeType) => {
        const iconMap = {
            // Images
            'image/jpeg': 'bi bi-file-image',
            'image/png': 'bi bi-file-image',
            'image/gif': 'bi bi-file-image',
            'image/svg+xml': 'bi bi-file-image',
            'image/bmp': 'bi bi-file-image',
            'image/webp': 'bi bi-file-image',

            // Documents
            'application/pdf': 'bi bi-file-earmark-pdf',
            'application/msword': 'bi bi-file-earmark-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'bi bi-file-earmark-word',
            'application/vnd.ms-excel': 'bi bi-file-earmark-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'bi bi-file-earmark-excel',
            'text/csv': 'bi bi-file-earmark-spreadsheet',
            'text/plain': 'bi bi-file-earmark-text',
            'application/json': 'bi bi-file-earmark-code',
            'application/xml': 'bi bi-file-earmark-code',

            // Audio
            'audio/mpeg': 'bi bi-file-earmark-music',
            'audio/wav': 'bi bi-file-earmark-music',
            'audio/ogg': 'bi bi-file-earmark-music',
            'audio/mp4': 'bi bi-file-earmark-music',

            // Video
            'video/mp4': 'bi bi-file-earmark-play',
            'video/quicktime': 'bi bi-file-earmark-play',
            'video/x-msvideo': 'bi bi-file-earmark-play',
            'video/x-ms-wmv': 'bi bi-file-earmark-play',
            'video/x-matroska': 'bi bi-file-earmark-play',
            'video/webm': 'bi bi-file-earmark-play',

            // Archives
            'application/zip': 'bi bi-file-earmark-zip',
            'application/x-rar-compressed': 'bi bi-file-earmark-zip',
            'application/x-tar': 'bi bi-file-earmark-zip',
            'application/gzip': 'bi bi-file-earmark-zip',

            // Other
            'text/html': 'bi bi-file-earmark-code',
            'text/css': 'bi bi-file-earmark-code',
            'application/javascript': 'bi bi-file-earmark-code',
        };

        // Default icon if MIME type not found
        return iconMap[mimeType] || 'bi bi-file-earmark';
    }

    return {
        date,
        mimeTypeIcon
    };
}
