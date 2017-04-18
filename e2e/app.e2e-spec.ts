import { Pro2017Page } from './app.po';

describe('pro2017 App', function() {
  let page: Pro2017Page;

  beforeEach(() => {
    page = new Pro2017Page();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
