-- Eve Mountain Gallery Images
-- Run this AFTER uploading all images to storage/app/public/gallery/
-- This clears old placeholder images and inserts the real ones.

START TRANSACTION;

-- Clear existing gallery images (remove if you want to keep old ones)
DELETE FROM gallery_images;

-- Reset auto-increment
ALTER TABLE gallery_images AUTO_INCREMENT = 1;

INSERT INTO gallery_images (filename, caption, category, sort_order, is_visible, created_at, updated_at) VALUES
  ('LEO09019.jpeg', 'Eve Mountain Campsite main building at sunset', 'facilities', 1, 1, NOW(), NOW()),
  ('LEO09029.jpeg', 'Outdoor seating area under the trees', 'general', 2, 1, NOW(), NOW()),
  ('LEO09032.jpeg', 'The campsite buildings surrounded by nature', 'general', 3, 1, NOW(), NOW()),
  ('LEO09036.jpeg', 'Main hall building with dramatic sky', 'facilities', 4, 1, NOW(), NOW()),
  ('LEO09040.jpeg', 'Campsite main building at golden hour', 'facilities', 5, 1, NOW(), NOW()),
  ('LEO09042.jpeg', 'Eve Mountain buildings nestled in trees', 'facilities', 6, 1, NOW(), NOW()),
  ('LEO09043.jpeg', 'Aerial view of the campsite grounds', 'general', 7, 1, NOW(), NOW()),
  ('LEO09045.jpeg', 'The campsite under an open sky', 'general', 8, 1, NOW(), NOW()),
  ('LEO09058.jpeg', 'Dormitory bunk beds', 'dorms', 9, 1, NOW(), NOW()),
  ('LEO09059.jpeg', 'Dormitory room overview', 'dorms', 10, 1, NOW(), NOW()),
  ('LEO09062.jpeg', 'Dormitory interior', 'dorms', 11, 1, NOW(), NOW()),
  ('LEO09067.jpeg', 'Dormitory bunk bed detail', 'dorms', 12, 1, NOW(), NOW()),
  ('LEO09069.jpeg', 'Dormitory accommodation', 'dorms', 13, 1, NOW(), NOW()),
  ('LEO09074.jpeg', 'Auditorium interior — spacious hall with projector', 'facilities', 14, 1, NOW(), NOW()),
  ('LEO09080.jpeg', 'Main hall ready for conferences and events', 'facilities', 15, 1, NOW(), NOW()),
  ('LEO09084.jpeg', 'Auditorium detail', 'facilities', 16, 1, NOW(), NOW()),
  ('LEO09087.jpeg', 'Epson projector mounted in the auditorium', 'facilities', 17, 1, NOW(), NOW()),
  ('LEO09088.jpeg', 'Auditorium hall with natural light', 'facilities', 18, 1, NOW(), NOW()),
  ('LEO09089.jpeg', 'Conference and meeting space', 'facilities', 19, 1, NOW(), NOW()),
  ('LEO09093.jpeg', 'Kitchen facilities', 'facilities', 20, 1, NOW(), NOW()),
  ('LEO09094.jpeg', 'Kitchen and cooking area', 'facilities', 21, 1, NOW(), NOW()),
  ('LEO09097.jpeg', 'Bathroom and ablution facilities', 'facilities', 22, 1, NOW(), NOW()),
  ('LEO09100.jpeg', 'Clean modern bathroom facilities', 'facilities', 23, 1, NOW(), NOW()),
  ('LEO09111.jpeg', 'Shower facilities', 'facilities', 24, 1, NOW(), NOW()),
  ('LEO09118.jpeg', 'Outdoor camping area in the bush', 'outdoor', 25, 1, NOW(), NOW()),
  ('LEO09119.jpeg', 'Natural bush setting at the campsite', 'outdoor', 26, 1, NOW(), NOW()),
  ('LEO09120.jpeg', 'Campsite outdoor environment', 'outdoor', 27, 1, NOW(), NOW()),
  ('LEO09125.jpeg', 'Teambuilding obstacle course area', 'activities', 28, 1, NOW(), NOW()),
  ('LEO09126.jpeg', 'Outdoor activity grounds', 'activities', 29, 1, NOW(), NOW()),
  ('LEO09131.jpeg', 'Teambuilding course with climbing structures', 'activities', 30, 1, NOW(), NOW()),
  ('LEO09134.jpeg', 'Open activity fields', 'activities', 31, 1, NOW(), NOW()),
  ('LEO09135.jpeg', 'Campsite activity area', 'activities', 32, 1, NOW(), NOW()),
  ('LEO09141.jpeg', 'Bush walking trails', 'outdoor', 33, 1, NOW(), NOW()),
  ('LEO09154.jpeg', 'Natural surroundings of Eve Mountain', 'outdoor', 34, 1, NOW(), NOW()),
  ('LEO09155.jpeg', 'Peaceful outdoor environment', 'outdoor', 35, 1, NOW(), NOW()),
  ('LEO09165.jpeg', 'African bush landscape at Eve Mountain', 'outdoor', 36, 1, NOW(), NOW()),
  ('LEO09190.jpeg', 'Welcome to Eve Mountain Campsite', 'general', 37, 1, NOW(), NOW()),
  ('LEO09195.jpeg', 'Eve Mountain Campsite entrance sign', 'general', 38, 1, NOW(), NOW()),
  ('mahuuu.jpeg', 'Eve Mountain Campsite dormitory block', 'general', 39, 1, NOW(), NOW());

COMMIT;

-- Verify
SELECT category, COUNT(*) as count FROM gallery_images GROUP BY category ORDER BY category;