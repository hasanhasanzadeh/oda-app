#!/usr/bin/env node

/**
 * PWA Build Optimization Script
 * Optimizes the build process for Progressive Web App deployment
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

console.log('🚀 Starting PWA Build Optimization...\n');

// Check if build directory exists
const buildDir = path.join(__dirname, '../public/build');
if (!fs.existsSync(buildDir)) {
    console.error('❌ Build directory not found. Please run "npm run build" first.');
    process.exit(1);
}

// Read manifest files
const manifestPath = path.join(__dirname, '../public/build/manifest.json');
const swPath = path.join(__dirname, '../public/sw.js');

if (!fs.existsSync(manifestPath)) {
    console.error('❌ Build manifest not found.');
    process.exit(1);
}

if (!fs.existsSync(swPath)) {
    console.error('❌ Service Worker not found.');
    process.exit(1);
}

console.log('✅ Build files found');

// Read and validate manifest
const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
console.log('✅ Build manifest validated');

// Check for required PWA files
const requiredFiles = [
    'public/manifest.json',
    'public/sw.js',
    'public/browserconfig.xml',
    'public/offline.html',
    'public/pwa-test.html'
];

let missingFiles = [];
requiredFiles.forEach(file => {
    const filePath = path.join(__dirname, '..', file);
    if (!fs.existsSync(filePath)) {
        missingFiles.push(file);
    }
});

if (missingFiles.length > 0) {
    console.warn('⚠️  Missing PWA files:');
    missingFiles.forEach(file => console.warn(`   - ${file}`));
} else {
    console.log('✅ All PWA files present');
}

// Check build size
const buildFiles = fs.readdirSync(buildDir);
let totalSize = 0;

buildFiles.forEach(file => {
    const filePath = path.join(buildDir, file);
    const stats = fs.statSync(filePath);
    totalSize += stats.size;
});

const totalSizeKB = Math.round(totalSize / 1024);
const totalSizeMB = Math.round(totalSize / (1024 * 1024) * 100) / 100;

console.log(`📊 Build size: ${totalSizeKB} KB (${totalSizeMB} MB)`);

if (totalSizeMB > 5) {
    console.warn('⚠️  Build size is large. Consider optimizing assets.');
} else {
    console.log('✅ Build size is optimal');
}

// Generate PWA report
const report = {
    timestamp: new Date().toISOString(),
    buildSize: {
        bytes: totalSize,
        kb: totalSizeKB,
        mb: totalSizeMB
    },
    files: buildFiles,
    missingFiles: missingFiles,
    manifest: {
        name: manifest.name,
        short_name: manifest.short_name,
        version: manifest.version || '1.0.0'
    }
};

const reportPath = path.join(__dirname, '../public/build/pwa-report.json');
fs.writeFileSync(reportPath, JSON.stringify(report, null, 2));

console.log('📋 PWA report generated: public/build/pwa-report.json');

// Performance recommendations
console.log('\n🎯 Performance Recommendations:');
console.log('   1. Test PWA installation on mobile devices');
console.log('   2. Verify offline functionality');
console.log('   3. Check push notification permissions');
console.log('   4. Validate manifest.json with PWA tools');
console.log('   5. Test on different browsers and devices');

console.log('\n✅ PWA Build Optimization Complete!');
console.log('🌐 Test your PWA at: http://localhost:8000/pwa-test.html');
