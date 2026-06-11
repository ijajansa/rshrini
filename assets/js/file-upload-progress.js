/**
 * File Upload Progress Handler
 * Handles AJAX file uploads with visual progress bar for video, audio, and PDF files
 */

function initializeFileUpload() {
    const form = document.getElementById('uploadForm');
    if (!form) {
        console.error('Upload form not found');
        return;
    }

    const fileInput = document.getElementById('fileInput');
    const progressSection = document.getElementById('progressSection');
    const progressBar = document.getElementById('progressBar');
    const progressPercentage = document.getElementById('progressPercentage');
    const uploadStatus = document.getElementById('uploadStatus');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');
    const chapterId = document.getElementById('chapterId');

    console.log('✓ File upload initialized');

    // File input change event
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            alertContainer.innerHTML = '';
            
            // Validate file type
            if (this.files[0]) {
                const file = this.files[0];
                const fileType = document.querySelector('input[name="type"]').value;
                const validationResult = validateFileType(file, fileType);
                
                if (!validationResult.valid) {
                    showAlert(validationResult.message, 'danger');
                    this.value = ''; // Clear the file input
                    return false;
                }
            }
        });
    }

    // Form submission with AJAX
    form.addEventListener('submit', function(e) {
        const chapter = chapterId.value;
        const file = fileInput.files[0];

        console.log('Form submitted - Chapter:', chapter, 'File:', file ? file.name : 'None');

        // Validation - chapter is required
        if (!chapter) {
            e.preventDefault();
            showAlert('Please select a chapter', 'warning');
            return false;
        }

        // If no file selected, allow normal form submission
        if (!file) {
            console.log('No file selected, allowing normal submission');
            return true; // Let the form submit normally
        }

        // File is selected, prevent default and do AJAX upload
        e.preventDefault();
        console.log('✓ File selected, doing AJAX upload');

        // Validate file type
        const fileTypeInput = document.querySelector('input[name="type"]');
        const fileType = fileTypeInput ? fileTypeInput.value : 'video';
        const validationResult = validateFileType(file, fileType);
        
        if (!validationResult.valid) {
            showAlert(validationResult.message, 'danger');
            return false;
        }

        // Check file size
        const maxSizes = {
            'video': 536870912,   // 512MB
            'audio': 322961408,   // 308MB
            'pdf': 214958080      // 205MB
        };

        const maxSize = maxSizes[fileType] || 536870912;

        if (file.size > maxSize) {
            const sizeMB = (maxSize / 1024 / 1024).toFixed(0);
            showAlert(`File size exceeds ${sizeMB}MB limit`, 'danger');
            return false;
        }

        // Get CSRF token
        const tokenInput = document.querySelector('input[name="_token"]');
        const token = tokenInput ? tokenInput.value : '';

        // Create FormData
        const formData = new FormData();
        formData.append('_token', token);
        formData.append('chapter_id', chapter);
        formData.append('type', fileType);
        formData.append('file', file);

        // Show progress section and disable submit button
        progressSection.style.display = 'block';
        submitBtn.disabled = true;
        progressBar.style.width = '0%';
        progressPercentage.textContent = '0%';
        uploadStatus.textContent = 'Starting upload...';
        const smallElem = progressBar.querySelector('small');
        if (smallElem) {
            smallElem.textContent = '0%';
        }

        console.log('✓ Starting upload of file:', file.name, 'Size:', file.size, 'Type:', fileType);

        // Create XMLHttpRequest for upload
        const xhr = new XMLHttpRequest();

        // Upload progress event
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                updateProgress(percentComplete, progressBar, progressPercentage, uploadStatus);
            }
        }, false);

        // Upload complete
        xhr.addEventListener('load', function() {
            console.log('✓ Upload complete, status:', xhr.status);
            console.log('Response text:', xhr.responseText.substring(0, 200)); // Log first 200 chars
            
            if (xhr.status === 200 || xhr.status === 201) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log('✓ Response parsed successfully:', response);
                    
                    progressBar.style.width = '100%';
                    progressPercentage.textContent = '100%';
                    const smallElem = progressBar.querySelector('small');
                    if (smallElem) {
                        smallElem.textContent = '100%';
                    }
                    uploadStatus.textContent = 'Upload successful!';

                    showAlert('File uploaded successfully!', 'success');

                    // Reset form after 2 seconds
                    setTimeout(function() {
                        form.reset();
                        progressSection.style.display = 'none';
                        submitBtn.disabled = false;
                        progressBar.style.width = '0%';
                        progressPercentage.textContent = '0%';
                        const smallElem = progressBar.querySelector('small');
                        if (smallElem) {
                            smallElem.textContent = '0%';
                        }
                        
                        // Redirect to formats list
                        setTimeout(function() {
                            window.location.href = response.redirect || window.location.href;
                        }, 1500);
                    }, 1000);
                } catch(e) {
                    console.error('Error parsing response:', e);
                    console.error('Raw response:', xhr.responseText);
                    showAlert('File uploaded successfully! Redirecting...', 'success');
                    
                    // Still redirect even if response parsing fails
                    setTimeout(function() {
                        form.reset();
                        progressSection.style.display = 'none';
                        submitBtn.disabled = false;
                        progressBar.style.width = '0%';
                        progressPercentage.textContent = '0%';
                        
                        // Try to extract redirect from response or use default
                        let redirectUrl = window.location.href;
                        try {
                            if (xhr.responseText.includes('redirect')) {
                                const urlMatch = xhr.responseText.match(/"redirect"\s*:\s*"([^"]+)"/);
                                if (urlMatch) redirectUrl = urlMatch[1];
                            }
                        } catch(e) {}
                        
                        setTimeout(function() {
                            window.location.href = redirectUrl;
                        }, 1500);
                    }, 1000);
                }
            } else {
                handleUploadError(xhr, progressSection, submitBtn);
            }
        });

        // Upload error
        xhr.addEventListener('error', function() {
            console.error('Upload failed');
            handleUploadError(xhr, progressSection, submitBtn);
        });

        // Upload abort
        xhr.addEventListener('abort', function() {
            console.warn('Upload aborted');
            progressSection.style.display = 'none';
            submitBtn.disabled = false;
            showAlert('Upload was cancelled', 'warning');
        });

        // Send the request
        const url = form.getAttribute('action');
        xhr.open('POST', url, true);
        // Add header to identify as AJAX request
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
}

/**
 * Validate file type based on format type
 */
function validateFileType(file, fileType) {
    // MIME types for each format
    const validTypes = {
        'video': [
            'video/mp4',
            'video/x-msvideo',
            'video/quicktime',
            'video/x-ms-asf',
            'video/x-flv',
            'video/webm',
            'video/x-ms-wmv',
            'video/mpeg',
            'video/3gpp'
        ],
        'audio': [
            'audio/mpeg',
            'audio/wav',
            'audio/x-wav',
            'audio/mp3',
            'audio/x-mp3',
            'audio/x-mpeg',
            'audio/m4a'
        ],
        'pdf': [
            'application/pdf'
        ]
    };

    // File extensions as backup
    const validExtensions = {
        'video': ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', 'mpg', 'mpeg', '3gp'],
        'audio': ['mp3', 'wav', 'm4a', 'flac', 'aac', 'ogg', 'wma'],
        'pdf': ['pdf']
    };

    const typeNames = {
        'video': 'Video',
        'audio': 'Audio',
        'pdf': 'PDF'
    };

    const allowed = validTypes[fileType] || [];
    const allowedExts = validExtensions[fileType] || [];
    const fileName = file.name.toLowerCase();
    const fileExt = fileName.split('.').pop();
    const mimeType = file.type.toLowerCase();

    // Check MIME type or extension
    const mimeValid = allowed.some(type => mimeType.includes(type.split('/')[0]) || mimeType === type);
    const extValid = allowedExts.includes(fileExt);

    if (!mimeValid && !extValid) {
        const formatName = typeNames[fileType] || 'file';
        const extList = allowedExts.join(', ').toUpperCase();
        return {
            valid: false,
            message: `Invalid file type! Please upload a ${formatName} file (${extList})`
        };
    }

    return { valid: true, message: '' };
}

/**
 * Update progress bar and status
 */
function updateProgress(percent, progressBar, progressPercentage, uploadStatus) {
    const roundedPercent = Math.round(percent);
    progressBar.style.width = roundedPercent + '%';
    const smallElem = progressBar.querySelector('small');
    if (smallElem) {
        smallElem.textContent = roundedPercent + '%';
    }
    progressPercentage.textContent = roundedPercent + '%';

    // Update status message based on progress
    if (roundedPercent < 30) {
        uploadStatus.textContent = 'Uploading file... ' + roundedPercent + '%';
    } else if (roundedPercent < 70) {
        uploadStatus.textContent = 'Uploading... ' + roundedPercent + '%';
    } else if (roundedPercent < 100) {
        uploadStatus.textContent = 'Almost done... ' + roundedPercent + '%';
    }
    
    console.log('Upload progress: ' + roundedPercent + '%');
}

/**
 * Handle upload errors
 */
function handleUploadError(xhr, progressSection, submitBtn) {
    progressSection.style.display = 'none';
    submitBtn.disabled = false;

    let errorMessage = 'An error occurred during upload.';

    if (xhr.status === 422) {
        try {
            const response = JSON.parse(xhr.responseText);
            const errors = response.errors;
            if (errors && errors.file) {
                errorMessage = errors.file[0];
            } else if (errors) {
                errorMessage = Object.values(errors).flat()[0];
            }
        } catch(e) {
            errorMessage = 'Validation error occurred';
        }
    } else if (xhr.status === 413) {
        errorMessage = 'File size is too large.';
    } else if (xhr.status >= 500) {
        errorMessage = 'Server error occurred. Please try again later.';
    } else if (xhr.status === 0) {
        errorMessage = 'Network error. Please check your connection.';
    }

    console.error('Upload error:', errorMessage);
    showAlert(errorMessage, 'danger');
}

/**
 * Display alert messages
 */
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alertClass = {
        'success': 'alert-success',
        'danger': 'alert-danger',
        'warning': 'alert-warning',
        'info': 'alert-info'
    };

    const alertIcon = {
        'success': 'fas fa-check-circle',
        'danger': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };

    const typeText = type.charAt(0).toUpperCase() + type.slice(1);
    const alertHTML = `
        <div class="alert ${alertClass[type] || 'alert-info'} alert-dismissible fade show" role="alert">
            <i class="${alertIcon[type] || alertIcon['info']}"></i> <strong>${typeText}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    alertContainer.innerHTML = alertHTML;
    console.log('Alert:', type, message);

    // Auto-dismiss success alerts after 5 seconds
    if (type === 'success') {
        setTimeout(function() {
            alertContainer.style.opacity = '1';
            alertContainer.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                alertContainer.style.opacity = '0';
                setTimeout(() => {
                    alertContainer.innerHTML = '';
                    alertContainer.style.opacity = '1';
                }, 500);
            }, 4500);
        }, 0);
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeFileUpload);
} else {
    initializeFileUpload();
}
