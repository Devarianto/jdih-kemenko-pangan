@extends('static.layouts.layout')

@section('content')
  <section>
    <div class="wrapper content-pages">
      <h1>Heading 1</h1>
      <h2>Heading 2</h2>
      <h3>Heading 3</h3>
      <h4>Heading 4</h4>
      <h5>Heading 5</h5>
      <h6>Heading 6</h6>
      <hr>
      <h5>Paragraph</h5>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis nesciunt rerum, architecto voluptatem ipsa dolor iste maxime, nobis minima reprehenderit voluptatibus itaque laboriosam. Magnam, quam quod. Iste, possimus! Praesentium, expedita.</p>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis nesciunt rerum, architecto voluptatem ipsa dolor iste maxime, nobis minima reprehenderit voluptatibus itaque laboriosam. Magnam, quam quod. Iste, possimus! Praesentium, expedita.</p>

      <h5>OL</h5>
      <ol>
        <li>Order List Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut id nam error inventore sed commodi quisquam, voluptates assumenda velit</li>
        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut id nam error inventore sed commodi quisquam, voluptates assumenda velit</li>
        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut id nam error inventore sed commodi quisquam, voluptates assumenda velit</li>
      </ol>

      <h5>UL</h5>
      <ul>
        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, ut possimus? Omnis, nihil error placeat ullam aperiam odio explicabo praesentium</li>
        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, ut possimus? Omnis, nihil error placeat ullam aperiam odio explicabo praesentium</li>
        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, ut possimus? Omnis, nihil error placeat ullam aperiam odio explicabo praesentium</li>
      </ul>
      <table>
        <thead>
          <tr>
            <th>Title1</th>
            <th>Title2</th>
            <th>Title3</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Content1</td>
            <td>Content2</td>
            <td>Content3</td>
          </tr>
          <tr>
            <td>Content1</td>
            <td>Content2</td>
            <td>Content3</td>
          </tr>
          <tr>
            <td>Content1</td>
            <td>Content2</td>
            <td>Content3</td>
          </tr>
        </tbody>
      </table>
      <section class="section-content">
        <h4>Radio Button</h4>
        <div class="row">
          <div class="column column-50">
            <h6>Large</h6>
            <label class="radio-custom">
              <input type="radio" name="radio-button">
              <i></i>
              <span>Radio Button 1</span>
            </label>
            <label class="radio-custom">
              <input type="radio" name="radio-button">
              <i></i>
              <span>Radio Button 2</span>
            </label>
          </div>
          <div class="column column-50">
            <h6>Small</h6>
            <label class="radio-custom radio-custom__small">
              <input type="radio" name="radio">
              <i></i>
              <span>Radio Button 1</span>
            </label>
            <label class="radio-custom radio-custom__small">
              <input type="radio" name="radio">
              <i></i>
              <span>Radio Button 2</span>
            </label>
          </div>
        </div>
      </section>
      <h5>Input Fields</h5>
<form action="">
  <div class="box-form">
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-large">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-small">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-large">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-small">
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-large" disabled>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" disabled>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <input type="text" name="" id="" placeholder="Placeholder" class="textfield-small" disabled>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <h6>Textarea</h6>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <textarea placeholder="Placeholder"></textarea>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <textarea placeholder="Placeholder"></textarea>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <textarea placeholder="Placeholder" disabled></textarea>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <h6>Select Box</h6>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <select>
          <option value="">Select Box</option>
        </select>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <select>
          <option value="">Select Box</option>
        </select>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <select disabled>
          <option value="">Select Box</option>
        </select>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <hr>
    <h4>Textfield with Icon</h4>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-right">
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-lr">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <div class="textfields-icon-right">
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <div class="textfields-icon-lr">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-right">
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-lr">
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <textarea placeholder="Placeholder"></textarea>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-right">
          <textarea placeholder="Placeholder"></textarea>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-lr">
          <i class="wa-ic-mail-outline"></i>
          <textarea placeholder="Placeholder"></textarea>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <select>
            <option value="">Select Box</option>
          </select>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <select>
            <option value="">Select Box</option>
          </select>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <label for="">Label</label>
        <div class="textfields-icon-left">
          <i class="wa-ic-mail-outline"></i>
          <select disabled>
            <option value="">Select Box</option>
          </select>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <hr>
    <h5>Textfield Inner Box</h5>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label textfields-icon-right">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label textfields-icon-lr">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33 error-field">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-label textfields-icon-right">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-label textfields-icon-lr">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label textfields-icon-right">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label textfields-icon-lr">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <i class="wa-ic-arrow-narrow-right-outline"></i>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-label">
          <label for="">Label</label>
          <textarea placeholder="Placeholder"></textarea>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-label">
          <label for="">Label</label>
          <textarea placeholder="Placeholder"></textarea>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label">
          <label for="">Label</label>
          <textarea placeholder="Placeholder" disabled></textarea>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <select>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <select>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-label textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <select disabled>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-label__box"></span>
        </div>
        <div class="supporting-text">Supporting Text (Optional)</div>
      </div>
    </div>
    <hr>
    <h5>Textfield Bottom Line</h5>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder">
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-bline">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder">
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-bline textfields-icon-left">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder">
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-bline textfields-icon-right">
          <label for="">Label</label>
          <input type="text" name="" id="" placeholder="Placeholder">
          <i class="wa-ic-arrow-narrow-right-solid"></i>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-bline textfields-icon-lr">
          <label for="">Label</label>
          <i class="wa-ic-mail-outline"></i>
          <input type="text" name="" id="" placeholder="Placeholder" disabled>
          <i class="wa-ic-arrow-narrow-right-solid"></i>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <textarea placeholder="Placeholder"></textarea>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-bline">
          <label for="">Label</label>
          <textarea placeholder="Placeholder"></textarea>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <textarea placeholder="Placeholder" disabled></textarea>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
    </div>
    <div class="row row-wrap">
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <select>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33 error-field">
        <div class="textfield-bline">
          <label for="">Label</label>
          <select>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
      <div class="column column-33">
        <div class="textfield-bline">
          <label for="">Label</label>
          <select disabled>
            <option value="">Select Box</option>
          </select>
          <span class="textfield-bline__box"></span>
        </div>
        <div class="supporting-text supporting-text__no-space">Supporting Text (Optional)</div>
      </div>
    </div>
  </div>
</form>
    </div>
  </section>
@endsection
